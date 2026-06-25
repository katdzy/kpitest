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
                'period',
                'actual_value',
                'target_value',
                'baseline_value',
                'department_code',
                'notes'
            ]);

            // Attempt to fetch sample KPIs and departments to pre-populate helpful rows
            $kpis = Kpi::limit(2)->get();
            $dept = Department::where('code', 'COE')->first() ?? Department::first();

            if ($kpis->count() > 0) {
                // First example: Institutional (no department code)
                $kpi1 = $kpis[0];
                fputcsv($handle, [
                    $kpi1->measure_code,
                    $kpi1->year_range,
                    str_replace('%', '', $kpi1->target) - 2, // slightly below target
                    str_replace('%', '', $kpi1->target),
                    str_replace('%', '', $kpi1->baseline),
                    '', // empty department code = university-wide
                    'Example university-wide target achievement entry'
                ]);

                if ($kpis->count() > 1) {
                    // Second example: Departmental (with department code)
                    $kpi2 = $kpis[1];
                    fputcsv($handle, [
                        $kpi2->measure_code,
                        '2025-Q1',
                        str_replace('%', '', $kpi2->target) + 1, // exceeding target
                        str_replace('%', '', $kpi2->target),
                        str_replace('%', '', $kpi2->baseline),
                        $dept ? $dept->code : 'COE',
                        'Example quarterly departmental contribution entry'
                    ]);
                }
            } else {
                // Fallback hardcoded examples if database has no KPIs
                fputcsv($handle, [
                    'UNIV-AC-001',
                    '2025-2026',
                    '64.5',
                    '65.0',
                    '60.0',
                    '',
                    'Example university-wide academic result'
                ]);
                fputcsv($handle, [
                    'UNIV-RE-002',
                    '2025-Q1',
                    '15.5',
                    '15.0',
                    '10.0',
                    'ORI',
                    'Example quarterly departmental research result'
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
            $requiredHeaders = ['measure_code', 'period', 'target_value'];
            $missing = array_diff($requiredHeaders, $headers);
            if (!empty($missing)) {
                fclose($handle);
                return redirect()->back()->withErrors([
                    'csv_file' => 'The CSV is missing required columns: ' . implode(', ', $missing) . '.'
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

            // Period check
            $period = trim($row['period'] ?? '');
            if (empty($period)) {
                $errors[] = "Row {$rowNum}: 'period' is required.";
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

            if (empty($errors)) {
                $validatedData[] = [
                    'kpi_id' => $allKpis[$measureCode],
                    'department_id' => !empty($deptCode) ? $allDepts[$deptCode] : null,
                    'period' => $period,
                    'target_value' => (double)$targetVal,
                    'actual_value' => $actualVal !== '' ? (double)$actualVal : null,
                    'baseline_value' => $baselineVal !== '' ? (double)$baselineVal : null,
                    'notes' => trim($row['notes'] ?? ''),
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
                $kpiResult = KpiResult::where('kpi_id', $data['kpi_id'])
                    ->where('department_id', $data['department_id'])
                    ->where('period', $data['period'])
                    ->first();

                if (!$kpiResult) {
                    $kpiResult = new KpiResult();
                    $kpiResult->kpi_id = $data['kpi_id'];
                    $kpiResult->department_id = $data['department_id'];
                    $kpiResult->period = $data['period'];
                }

                $kpiResult->target_value = $data['target_value'];
                $kpiResult->actual_value = $data['actual_value'];
                $kpiResult->baseline_value = $data['baseline_value'];
                $kpiResult->notes = $data['notes'];
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
