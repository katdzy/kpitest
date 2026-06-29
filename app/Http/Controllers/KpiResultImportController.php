<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Kpi;
use App\Models\KpiResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KpiResultImportController extends Controller
{
    /**
     * Show the CSV upload form.
     */
    public function show()
    {
        return view('kpis.import');
    }

    /**
     * Download a sample CSV template with example data from the database.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="kpi_results_template.csv"',
        ];

        return new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Write CSV headers
            fputcsv($handle, [
                'measure_code',
                'school_year',
                'report_type',
                'actual_value',
                'target_value',
                'baseline_value',
                'department_code',
                'notes',
                'initiative_outcome'
            ]);

            // Attempt to fetch sample KPIs and departments to pre-populate helpful rows
            $kpis = Kpi::limit(2)->get();
            $dept = Department::where('code', 'COE')->first() ?? Department::first();

            if ($kpis->count() > 0) {
                // First example: Mid-Year Institutional
                $kpi1 = $kpis[0];
                fputcsv($handle, [
                    $kpi1->measure_code,
                    '2025-2026',
                    'Mid-Year',
                    str_replace('%', '', $kpi1->target) !== '' && is_numeric(str_replace('%', '', $kpi1->target)) ? str_replace('%', '', $kpi1->target) - 2 : '65.0',
                    str_replace('%', '', $kpi1->target) !== '' && is_numeric(str_replace('%', '', $kpi1->target)) ? str_replace('%', '', $kpi1->target) : '67.0',
                    str_replace('%', '', $kpi1->baseline) !== '' && is_numeric(str_replace('%', '', $kpi1->baseline)) ? str_replace('%', '', $kpi1->baseline) : '60.0',
                    '', // empty department code = university-wide
                    'Example university-wide mid-year progress notes',
                    '' // initiative outcome is Year-Ender only
                ]);

                if ($kpis->count() > 1) {
                    // Second example: Year-Ender Departmental
                    $kpi2 = $kpis[1];
                    fputcsv($handle, [
                        $kpi2->measure_code,
                        '2025-2026',
                        'Year-Ender',
                        str_replace('%', '', $kpi2->target) !== '' && is_numeric(str_replace('%', '', $kpi2->target)) ? str_replace('%', '', $kpi2->target) + 1 : '85.0',
                        str_replace('%', '', $kpi2->target) !== '' && is_numeric(str_replace('%', '', $kpi2->target)) ? str_replace('%', '', $kpi2->target) : '84.0',
                        str_replace('%', '', $kpi2->baseline) !== '' && is_numeric(str_replace('%', '', $kpi2->baseline)) ? str_replace('%', '', $kpi2->baseline) : '80.0',
                        $dept ? $dept->code : 'COE',
                        'Example departmental year-end notes',
                        'The board exam review program was conducted successfully with higher attendance rates.'
                    ]);
                }
            } else {
                // Fallback hardcoded examples if database has no KPIs
                fputcsv($handle, [
                    'UNIV-AC-001',
                    '2025-2026',
                    'Mid-Year',
                    '64.5',
                    '65.0',
                    '60.0',
                    '',
                    'Mid-year academic performance review description',
                    ''
                ]);
                fputcsv($handle, [
                    'UNIV-RE-002',
                    '2025-2026',
                    'Year-Ender',
                    '15.5',
                    '15.0',
                    '10.0',
                    'ORI',
                    'Final research target achieved',
                    'Funded research journals published in indexed scopes.'
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Import KPI results from uploaded CSV file.
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // 1. Read and parse file rows
        $rows = [];
        $headers = [];
        if (($handle = fopen($path, 'r')) !== false) {
            // Strip BOM if present
            $bom = fread($handle, 3);
            if ($bom !== chr(0xEF).chr(0xBB).chr(0xBF)) {
                rewind($handle);
            }

            // Get headers
            $rawHeaders = fgetcsv($handle);
            if ($rawHeaders) {
                $headers = array_map(fn($h) => strtolower(trim($h)), $rawHeaders);
            }

            // Validate header structure
            $requiredHeaders = ['measure_code', 'target_value'];
            $missing = array_diff($requiredHeaders, $headers);
            if (!empty($missing)) {
                fclose($handle);
                return redirect()->back()->withErrors([
                    'csv_file' => 'The CSV is missing required columns: ' . implode(', ', $missing) . '.'
                ]);
            }

            // Check that either period OR (school_year and report_type) are present
            if (!in_array('period', $headers) && (!in_array('school_year', $headers) || !in_array('report_type', $headers))) {
                fclose($handle);
                return redirect()->back()->withErrors([
                    'csv_file' => 'The CSV must contain either the "period" column OR both "school_year" and "report_type" columns.'
                ]);
            }

            // Read rows
            while (($data = fgetcsv($handle)) !== false) {
                // Skip empty rows
                if (empty(array_filter($data))) {
                    continue;
                }
                
                // Pad or slice row data to match headers length
                if (count($data) < count($headers)) {
                    $data = array_pad($data, count($headers), '');
                } else if (count($data) > count($headers)) {
                    $data = array_slice($data, 0, count($headers));
                }

                $rows[] = array_combine($headers, $data);
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return redirect()->back()->withErrors(['csv_file' => 'The uploaded CSV file is empty.']);
        }

        // 2. PASS 1: Validation
        $errors = [];
        $validatedData = [];
        
        // Cache active KPIs and Departments for faster lookup
        $allKpis = Kpi::all()->pluck('id', 'measure_code')->toArray();
        $allDepts = Department::all()->pluck('id', 'code')->toArray();

        foreach ($rows as $index => $row) {
            $rowNum = $index + 2; // Offset for header row and 1-based indexing

            // Measure Code check
            $measureCode = trim($row['measure_code'] ?? '');
            if (empty($measureCode)) {
                $errors[] = "Row {$rowNum}: 'measure_code' is required.";
            } elseif (!array_key_exists($measureCode, $allKpis)) {
                $errors[] = "Row {$rowNum}: KPI Code '{$measureCode}' does not exist in the KPI Library.";
            }

            // Values check
            $targetVal = trim($row['target_value'] ?? '');
            if ($targetVal === '') {
                $errors[] = "Row {$rowNum}: 'target_value' is required.";
            } elseif (!is_numeric($targetVal)) {
                $errors[] = "Row {$rowNum}: 'target_value' must be a valid number.";
            }

            $actualVal = trim($row['actual_value'] ?? '');
            if ($actualVal !== '' && !is_numeric($actualVal)) {
                $errors[] = "Row {$rowNum}: 'actual_value' must be a valid number if provided.";
            }

            $baselineVal = trim($row['baseline_value'] ?? '');
            if ($baselineVal !== '' && !is_numeric($baselineVal)) {
                $errors[] = "Row {$rowNum}: 'baseline_value' must be a valid number if provided.";
            }

            // Department code check
            $deptCode = trim($row['department_code'] ?? '');
            if (!empty($deptCode) && !array_key_exists($deptCode, $allDepts)) {
                $errors[] = "Row {$rowNum}: Department Code '{$deptCode}' does not exist in the system.";
            }

            // Period and BSC specific fields checks
            $schoolYear = null;
            $reportType = null;
            $period = null;

            if (array_key_exists('school_year', $row) || array_key_exists('report_type', $row)) {
                $schoolYear = trim($row['school_year'] ?? '');
                $reportType = trim($row['report_type'] ?? '');
                
                if (empty($schoolYear)) {
                    $errors[] = "Row {$rowNum}: 'school_year' is required.";
                } elseif (!in_array($schoolYear, ['2024-2025', '2025-2026', '2026-2027', '2027-2028', '2028-2029'])) {
                    $errors[] = "Row {$rowNum}: 'school_year' '{$schoolYear}' must be a valid school year between 2024-2025 and 2028-2029.";
                }
                
                if (empty($reportType)) {
                    $errors[] = "Row {$rowNum}: 'report_type' is required.";
                } elseif (!in_array($reportType, ['Mid-Year', 'Year-Ender'])) {
                    $errors[] = "Row {$rowNum}: 'report_type' '{$reportType}' must be either 'Mid-Year' or 'Year-Ender'.";
                }
                
                $period = array_key_exists('period', $row) ? trim($row['period'] ?? '') : $schoolYear . '-' . ($reportType === 'Mid-Year' ? 'MY' : 'YE');
            } else {
                $period = trim($row['period'] ?? '');
                if (empty($period)) {
                    $errors[] = "Row {$rowNum}: 'period' is required.";
                }
                
                // Fallbacks from period
                if (preg_match('/^(\d{4}-\d{4})/', $period, $matches)) {
                    $schoolYear = $matches[1];
                }
                if (str_contains(strtolower($period), 'mid') || str_contains(strtolower($period), '-my')) {
                    $reportType = 'Mid-Year';
                } elseif (str_contains(strtolower($period), 'end') || str_contains(strtolower($period), '-ye')) {
                    $reportType = 'Year-Ender';
                } else {
                    $reportType = 'Mid-Year';
                }
            }

            $initiativeOutcome = array_key_exists('initiative_outcome', $row) ? trim($row['initiative_outcome'] ?? '') : null;

            if (empty($errors)) {
                $validatedData[] = [
                    'kpi_id' => $allKpis[$measureCode],
                    'department_id' => !empty($deptCode) ? $allDepts[$deptCode] : null,
                    'period' => $period,
                    'school_year' => $schoolYear,
                    'report_type' => $reportType,
                    'target_value' => (double)$targetVal,
                    'actual_value' => $actualVal !== '' ? (double)$actualVal : null,
                    'baseline_value' => $baselineVal !== '' ? (double)$baselineVal : null,
                    'notes' => trim($row['notes'] ?? ''),
                    'initiative_outcome' => $initiativeOutcome,
                ];
            }
        }

        // Return error list if any row failed validation
        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('import_errors', $errors);
        }

        // 3. PASS 2: Save records in transaction
        try {
            DB::beginTransaction();

            $importedCount = 0;
            foreach ($validatedData as $data) {
                // Find or create result
                $query = KpiResult::where('kpi_id', $data['kpi_id'])
                    ->where('department_id', $data['department_id']);
                
                if (!empty($data['school_year']) && !empty($data['report_type'])) {
                    $query->where('school_year', $data['school_year'])
                          ->where('report_type', $data['report_type']);
                } else {
                    $query->where('period', $data['period']);
                }

                $kpiResult = $query->first();

                if (!$kpiResult) {
                    $kpiResult = new KpiResult();
                    $kpiResult->kpi_id = $data['kpi_id'];
                    $kpiResult->department_id = $data['department_id'];
                    $kpiResult->period = $data['period'];
                }

                if (!empty($data['school_year'])) {
                    $kpiResult->school_year = $data['school_year'];
                }
                if (!empty($data['report_type'])) {
                    $kpiResult->report_type = $data['report_type'];
                }

                $kpiResult->target_value = $data['target_value'];
                $kpiResult->actual_value = $data['actual_value'];
                $kpiResult->baseline_value = $data['baseline_value'];
                $kpiResult->notes = $data['notes'];
                if ($data['initiative_outcome'] !== null) {
                    $kpiResult->initiative_outcome = $data['initiative_outcome'];
                }
                $kpiResult->imported_from = 'Manual';
                
                // Force load relationship for polarity mapping in computeStatus()
                $kpiResult->load('kpi');
                $kpiResult->status = $kpiResult->computeStatus();
                
                $kpiResult->save();
                $importedCount++;
            }

            DB::commit();

            return redirect()->route('kpis.index')
                ->with('success', "Success! Successfully imported {$importedCount} KPI performance results.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['csv_file' => 'Database transaction failed: ' . $e->getMessage()]);
        }
    }
}
