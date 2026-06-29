<?php

use App\Models\Department;
use App\Models\Kpi;
use App\Models\KpiResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('can import csv with school_year and report_type', function () {
    // Arrange: Seed KPI and Department
    $kpi = Kpi::create([
        'measure_code' => 'UNIV-AC-001',
        'measure_name' => 'Graduation Rate',
        'measure_owner' => 'Provost Office',
        'measure_type' => 'Academic Excellence',
        'category' => 'Academic',
        'year_range' => '2025-2026',
        'scope' => 'Institutional',
        'polarity' => 'Positive',
        'target' => '65.0',
        'baseline' => '60.0',
    ]);
    
    $dept = Department::create([
        'code' => 'COE', 
        'name' => 'College of Engineering',
        'college' => 'Engineering and Technology',
    ]);

    // Create CSV content in BSC format
    $csvContent = "measure_code,school_year,report_type,actual_value,target_value,baseline_value,department_code,notes,initiative_outcome\n"
                . "UNIV-AC-001,2025-2026,Mid-Year,64.0,65.0,60.0,COE,Mid year note,\n"
                . "UNIV-AC-001,2025-2026,Year-Ender,66.0,65.0,60.0,,Year end note,Strategic review successfully finalized\n";

    $file = UploadedFile::fake()->createWithContent('import_bsc.csv', $csvContent);

    // Act
    $response = $this->post('/kpis/import', [
        'csv_file' => $file
    ]);

    // Assert
    $response->assertRedirect('/kpis');
    $response->assertSessionHas('success');

    // Assert records exist in DB
    $this->assertDatabaseHas('kpi_results', [
        'kpi_id' => $kpi->id,
        'department_id' => $dept->id,
        'school_year' => '2025-2026',
        'report_type' => 'Mid-Year',
        'actual_value' => 64.0,
        'target_value' => 65.0,
        'notes' => 'Mid year note',
    ]);

    $this->assertDatabaseHas('kpi_results', [
        'kpi_id' => $kpi->id,
        'department_id' => null,
        'school_year' => '2025-2026',
        'report_type' => 'Year-Ender',
        'actual_value' => 66.0,
        'target_value' => 65.0,
        'notes' => 'Year end note',
        'initiative_outcome' => 'Strategic review successfully finalized',
    ]);
});

test('triggers validation error on invalid school_year or report_type', function () {
    // Arrange: Seed KPI
    $kpi = Kpi::create([
        'measure_code' => 'UNIV-AC-001',
        'measure_name' => 'Graduation Rate',
        'measure_owner' => 'Provost Office',
        'measure_type' => 'Academic Excellence',
        'category' => 'Academic',
        'year_range' => '2025-2026',
        'scope' => 'Institutional',
        'polarity' => 'Positive',
        'target' => '65.0',
        'baseline' => '60.0',
    ]);

    // Create CSV content with invalid school_year
    $csvContent = "measure_code,school_year,report_type,actual_value,target_value\n"
                . "UNIV-AC-001,2099-2100,Mid-Year,64.0,65.0\n";

    $file = UploadedFile::fake()->createWithContent('import_invalid.csv', $csvContent);

    // Act
    $response = $this->post('/kpis/import', [
        'csv_file' => $file
    ]);

    // Assert
    $response->assertRedirect();
    $response->assertSessionHas('import_errors');
    $errors = session('import_errors');
    $this->assertStringContainsString("Row 2: 'school_year' '2099-2100' must be a valid school year", $errors[0]);
});
