<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use App\Models\KpiResult;
use App\Models\Department;
use Illuminate\Http\Request;

class KpiReportController extends Controller
{
    /** Valid school years for the 5-year plan. */
    private const SCHOOL_YEARS = [
        '2024-2025',
        '2025-2026',
        '2026-2027',
        '2027-2028',
        '2028-2029',
    ];

    /** Map a school year to the corresponding 5-year target field on the KPI. */
    private const YEAR_TARGET_MAP = [
        '2024-2025' => 'target_2024',
        '2025-2026' => 'target_2025',
        '2026-2027' => 'target_2026',
        '2027-2028' => 'target_2027',
        '2028-2029' => 'target_2028',
    ];

    /**
     * Show the report submission form for a KPI.
     */
    public function create(Request $request, Kpi $kpi)
    {
        // Pre-fill from query params (e.g., ?school_year=2025-2026&report_type=Mid-Year)
        $selectedYear = $request->input('school_year');
        $selectedType = $request->input('report_type');

        // Load existing reports so the form can show what has already been submitted
        $existingReports = KpiResult::where('kpi_id', $kpi->id)
            ->whereNotNull('report_type')
            ->orderBy('school_year')
            ->orderByRaw("CASE report_type WHEN 'Mid-Year' THEN 1 ELSE 2 END")
            ->get()
            ->groupBy('school_year');

        $departments = Department::orderBy('name')->get();

        return view('kpis.reports.create', compact(
            'kpi',
            'selectedYear',
            'selectedType',
            'existingReports',
            'departments',
        ))->with('schoolYears', self::SCHOOL_YEARS);
    }

    /**
     * Store a new Mid-Year or Year-Ender report.
     */
    public function store(Request $request, Kpi $kpi)
    {
        $validated = $request->validate([
            'school_year'        => ['required', 'in:' . implode(',', self::SCHOOL_YEARS)],
            'report_type'        => ['required', 'in:Mid-Year,Year-Ender'],
            'actual_value'       => ['required', 'numeric'],
            'notes'              => ['nullable', 'string', 'max:2000'],
            'initiative_outcome' => ['nullable', 'string', 'max:3000'],
            'submitted_by'       => ['nullable', 'string', 'max:255'],
            'department_id'      => ['nullable', 'exists:departments,id'],
        ]);

        // Pull the target value for this school year from the KPI's 5-year plan fields
        $targetField  = self::YEAR_TARGET_MAP[$validated['school_year']] ?? null;
        $targetValue  = $targetField ? (float) ($kpi->{$targetField} ?? 0) : 0;
        $actualValue  = (float) $validated['actual_value'];

        // Auto-compute performance status
        $status = $this->computeStatus($actualValue, $targetValue, $kpi->polarity, $kpi->high_threshold, $kpi->low_threshold);

        KpiResult::create([
            'kpi_id'             => $kpi->id,
            'department_id'      => $validated['department_id'] ?? null,
            'school_year'        => $validated['school_year'],
            'report_type'        => $validated['report_type'],
            'period'             => $validated['school_year'] . ' ' . $validated['report_type'],
            'actual_value'       => $actualValue,
            'target_value'       => $targetValue,
            'baseline_value'     => (float) ($kpi->baseline ?? 0),
            'status'             => $status,
            'notes'              => $validated['notes'] ?? null,
            'initiative_outcome' => $validated['initiative_outcome'] ?? null,
            'submitted_by'       => $validated['submitted_by'] ?? null,
            'submitted_at'       => now(),
            'is_final'           => $validated['report_type'] === 'Year-Ender',
        ]);

        return redirect()
            ->route('kpis.show', $kpi->id)
            ->with('success', "{$validated['report_type']} report for {$validated['school_year']} submitted successfully.");
    }

    /**
     * Compute the performance status label given actual, target, and KPI polarity.
     */
    private function computeStatus(
        float $actual,
        float $target,
        ?string $polarity,
        $highThreshold,
        $lowThreshold
    ): string {
        if ($target <= 0) {
            return 'On Track';
        }

        // Numeric thresholds from the KPI — strip any "%" suffix
        $high = $highThreshold ? (float) preg_replace('/[^0-9.]/', '', $highThreshold) : null;
        $low  = $lowThreshold  ? (float) preg_replace('/[^0-9.]/', '', $lowThreshold)  : null;

        if ($polarity === 'Negative') {
            // Lower is better — e.g. dropout rate
            if ($low !== null && $actual <= $low) return 'On Track';
            if ($high !== null && $actual >= $high) return 'Off Track';
            return 'Warning';
        }

        // Default: Positive polarity (higher is better)
        $ratio = $actual / $target;

        if ($ratio >= 1.0)  return 'On Track';
        if ($ratio >= 0.85) return 'Warning';
        return 'Off Track';
    }
}
