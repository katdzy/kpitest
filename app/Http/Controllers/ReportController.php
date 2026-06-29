<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use App\Models\KpiResult;
use App\Models\Objective;
use App\Models\Perspective;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /** The 5 school years covered by the BSC strategic plan. */
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
     * Reports Hub — landing page listing all school years with summary gauges.
     */
    public function index()
    {
        $schoolYears = self::SCHOOL_YEARS;
        $totalKpis = Kpi::count();

        // For each school year, count submitted reports
        $yearSummaries = [];
        foreach ($schoolYears as $sy) {
            $midYearCount = KpiResult::where('school_year', $sy)
                ->where('report_type', 'Mid-Year')
                ->distinct('kpi_id')
                ->count('kpi_id');

            $yearEnderCount = KpiResult::where('school_year', $sy)
                ->where('report_type', 'Year-Ender')
                ->distinct('kpi_id')
                ->count('kpi_id');

            // Status counts for this school year
            $statusCounts = KpiResult::where('school_year', $sy)
                ->selectRaw("status, count(*) as total")
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            $yearSummaries[$sy] = [
                'mid_year_count'   => $midYearCount,
                'year_ender_count' => $yearEnderCount,
                'total_kpis'       => $totalKpis,
                'on_track'         => $statusCounts['On Track'] ?? 0,
                'warning'          => $statusCounts['Warning'] ?? 0,
                'off_track'        => $statusCounts['Off Track'] ?? 0,
                'pending'          => $statusCounts['Pending'] ?? 0,
            ];
        }

        return view('reports.index', compact('schoolYears', 'yearSummaries', 'totalKpis'));
    }

    /**
     * Annual School Year Report — full KPI scorecard grouped by Perspective → Objective.
     */
    public function schoolYear(string $school_year)
    {
        $this->validateSchoolYear($school_year);

        $perspectives = Perspective::with(['objectives' => function ($q) {
            $q->with(['kpis' => function ($q2) {
                $q2->with(['results', 'bscPerspective']);
            }])->orderBy('order');
        }])->orderBy('order')->get();

        // KPIs not assigned to any objective (unmapped)
        $unmappedKpis = Kpi::whereNull('objective_id')
            ->with('results')
            ->orderBy('measure_code')
            ->get();

        // Get results for this school year keyed by kpi_id
        $results = KpiResult::where('school_year', $school_year)
            ->get()
            ->groupBy('kpi_id');

        // Compute status summary
        $statusSummary = $this->computeStatusSummary($school_year);

        return view('reports.school_year', compact(
            'school_year',
            'perspectives',
            'unmappedKpis',
            'results',
            'statusSummary',
        ));
    }

    /**
     * Mid-Year Report — focused on mid-year submissions, at-risk KPIs, and gaps.
     */
    public function midYear(string $school_year)
    {
        $this->validateSchoolYear($school_year);

        $perspectives = Perspective::with(['objectives' => function ($q) {
            $q->with(['kpis'])->orderBy('order');
        }])->orderBy('order')->get();

        $unmappedKpis = Kpi::whereNull('objective_id')
            ->orderBy('measure_code')
            ->get();

        // Mid-year results keyed by kpi_id
        $midYearResults = KpiResult::where('school_year', $school_year)
            ->where('report_type', 'Mid-Year')
            ->get()
            ->keyBy('kpi_id');

        // All KPI IDs
        $allKpiIds = Kpi::pluck('id')->toArray();
        $reportedKpiIds = $midYearResults->keys()->toArray();
        $pendingKpiIds = array_diff($allKpiIds, $reportedKpiIds);

        // At-risk: Warning or Off Track
        $atRiskResults = $midYearResults->filter(function ($r) {
            return in_array($r->status, ['Warning', 'Off Track']);
        });

        $statusSummary = [
            'total'      => count($allKpiIds),
            'reported'   => count($reportedKpiIds),
            'pending'    => count($pendingKpiIds),
            'on_track'   => $midYearResults->where('status', 'On Track')->count(),
            'warning'    => $midYearResults->where('status', 'Warning')->count(),
            'off_track'  => $midYearResults->where('status', 'Off Track')->count(),
        ];

        return view('reports.mid_year', compact(
            'school_year',
            'perspectives',
            'unmappedKpis',
            'midYearResults',
            'atRiskResults',
            'statusSummary',
            'pendingKpiIds',
        ));
    }

    /**
     * Year-Ender Report — final scorecard with YoY comparison and initiative outcomes.
     */
    public function yearEnder(string $school_year)
    {
        $this->validateSchoolYear($school_year);

        $perspectives = Perspective::with(['objectives' => function ($q) {
            $q->with(['kpis'])->orderBy('order');
        }])->orderBy('order')->get();

        $unmappedKpis = Kpi::whereNull('objective_id')
            ->orderBy('measure_code')
            ->get();

        // Year-Ender results keyed by kpi_id
        $yearEnderResults = KpiResult::where('school_year', $school_year)
            ->where('report_type', 'Year-Ender')
            ->get()
            ->keyBy('kpi_id');

        // Previous year's Year-Ender for YoY comparison
        $prevYear = $this->previousSchoolYear($school_year);
        $prevYearResults = $prevYear
            ? KpiResult::where('school_year', $prevYear)
                ->where('report_type', 'Year-Ender')
                ->get()
                ->keyBy('kpi_id')
            : collect();

        $allKpiIds = Kpi::pluck('id')->toArray();
        $reportedKpiIds = $yearEnderResults->keys()->toArray();

        $statusSummary = [
            'total'      => count($allKpiIds),
            'reported'   => count($reportedKpiIds),
            'pending'    => count($allKpiIds) - count($reportedKpiIds),
            'on_track'   => $yearEnderResults->where('status', 'On Track')->count(),
            'warning'    => $yearEnderResults->where('status', 'Warning')->count(),
            'off_track'  => $yearEnderResults->where('status', 'Off Track')->count(),
        ];

        return view('reports.year_ender', compact(
            'school_year',
            'perspectives',
            'unmappedKpis',
            'yearEnderResults',
            'prevYearResults',
            'prevYear',
            'statusSummary',
        ));
    }

    /**
     * 5-Year Plan Overview — O1–O15 across all 5 school years as an executive grid.
     */
    public function fiveYearPlan()
    {
        $schoolYears = self::SCHOOL_YEARS;

        $perspectives = Perspective::with(['objectives' => function ($q) {
            $q->with(['kpis.results'])->orderBy('order');
        }])->orderBy('order')->get();

        // Build the matrix: objective_id → school_year → [statuses]
        $matrix = [];
        $yearTotals = array_fill_keys($schoolYears, ['on_track' => 0, 'warning' => 0, 'off_track' => 0, 'pending' => 0, 'total' => 0]);

        foreach ($perspectives as $perspective) {
            foreach ($perspective->objectives as $objective) {
                foreach ($objective->kpis as $kpi) {
                    foreach ($schoolYears as $sy) {
                        // Get the best result for this KPI+school_year (prefer Year-Ender over Mid-Year)
                        $result = $kpi->results
                            ->where('school_year', $sy)
                            ->sortByDesc(fn($r) => $r->report_type === 'Year-Ender' ? 1 : 0)
                            ->first();

                        $status = $result ? $result->status : 'Pending';
                        $targetField = self::YEAR_TARGET_MAP[$sy] ?? null;
                        $target = $targetField ? $kpi->{$targetField} : null;

                        $matrix[$objective->id][$sy][] = [
                            'kpi_id'       => $kpi->id,
                            'kpi_code'     => $kpi->measure_code,
                            'kpi_name'     => $kpi->measure_name,
                            'target'       => $target,
                            'actual'       => $result->actual_value ?? null,
                            'status'       => $status,
                        ];

                        // Tally for year totals
                        $yearTotals[$sy]['total']++;
                        $statusKey = match ($status) {
                            'On Track'  => 'on_track',
                            'Warning'   => 'warning',
                            'Off Track' => 'off_track',
                            default     => 'pending',
                        };
                        $yearTotals[$sy][$statusKey]++;
                    }
                }
            }
        }

        return view('reports.five_year_plan', compact(
            'schoolYears',
            'perspectives',
            'matrix',
            'yearTotals',
        ));
    }

    /**
     * Interactive Strategy Map Page.
     */
    public function strategyMap(Request $request)
    {
        $schoolYears = self::SCHOOL_YEARS;
        $school_year = $request->input('school_year', '2025-2026');

        if (!in_array($school_year, $schoolYears)) {
            $school_year = '2025-2026';
        }

        $perspectives = Perspective::with(['objectives' => function ($q) {
            $q->with(['kpis.results'])->orderBy('order');
        }])->orderBy('order')->get();

        // Fetch unmapped KPIs
        $unmappedKpis = Kpi::whereNull('objective_id')
            ->with('results')
            ->orderBy('measure_code')
            ->get();

        $targetFieldMap = self::YEAR_TARGET_MAP;

        return view('reports.strategy_map', compact(
            'perspectives',
            'unmappedKpis',
            'schoolYears',
            'school_year',
            'targetFieldMap'
        ));
    }

    // ── Helpers ──────────────────────────────────────────────────

    private function validateSchoolYear(string $sy): void
    {
        if (!in_array($sy, self::SCHOOL_YEARS)) {
            abort(404, "Invalid school year: {$sy}");
        }
    }

    private function previousSchoolYear(string $sy): ?string
    {
        $idx = array_search($sy, self::SCHOOL_YEARS);
        return ($idx !== false && $idx > 0) ? self::SCHOOL_YEARS[$idx - 1] : null;
    }

    private function computeStatusSummary(string $school_year): array
    {
        $totalKpis = Kpi::count();
        $results = KpiResult::where('school_year', $school_year)->get();

        $midYearReported = $results->where('report_type', 'Mid-Year')->unique('kpi_id')->count();
        $yearEnderReported = $results->where('report_type', 'Year-Ender')->unique('kpi_id')->count();

        // Aggregate status from the latest result per KPI
        $latestByKpi = $results->sortByDesc('created_at')->unique('kpi_id');

        return [
            'total'              => $totalKpis,
            'mid_year_reported'  => $midYearReported,
            'year_ender_reported'=> $yearEnderReported,
            'on_track'           => $latestByKpi->where('status', 'On Track')->count(),
            'warning'            => $latestByKpi->where('status', 'Warning')->count(),
            'off_track'          => $latestByKpi->where('status', 'Off Track')->count(),
            'pending'            => $totalKpis - $latestByKpi->count(),
        ];
    }
}
