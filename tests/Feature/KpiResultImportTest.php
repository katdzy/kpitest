<?php

use App\Models\Department;
use App\Models\Kpi;
use App\Models\KpiResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('can access import form', function () {
    $response = $this->get('/kpis/import');
    $response->assertStatus(200);
    $response->assertSee('Upload Performance Data CSV File');
});

test('can download csv template', function () {
    // Seed some data so the dynamic template can fetch examples
    Department::create([
        'code' => 'COE', 
        'name' => 'College of Engineering',
        'college' => 'Engineering and Technology',
    ]);
    Kpi::create([
        'measure_code' => 'UNIV-AC-001',
        'measure_name' => 'Graduation Rate',
        'measure_owner' => 'Provost Office',
        'measure_type' => 'Academic Excellence',
        'category' => 'Academic',
        'year_range' => '2025-2026',
        'scope' => 'Institutional',
        'target' => '65.0',
        'baseline' => '60.0',
    ]);

    $response = $this->get('/kpis/import/template');
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    $response->assertHeader('Content-Disposition', 'attachment; filename="kpi_results_template.csv"');
    
    $content = $response->streamedContent();
    $this->assertStringContainsString('measure_code,period,actual_value,target_value,baseline_value,department_code,notes', $content);
    $this->assertStringContainsString('UNIV-AC-001', $content);
});

test('can import valid csv file', function () {
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

    // Create CSV content
    $csvContent = "measure_code,period,actual_value,target_value,baseline_value,department_code,notes\n"
                . "UNIV-AC-001,2025-Q1,64.0,65.0,60.0,COE,Q1 assessment done\n"
                . "UNIV-AC-001,2025-Q2,66.0,65.0,60.0,,University-wide result\n";

    $file = UploadedFile::fake()->createWithContent('import.csv', $csvContent);

    // Act
    $response = $this->post('/kpis/import', [
        'csv_file' => $file
    ]);

    // Assert
    $response->assertRedirect('/kpis');
    $response->assertSessionHas('success');

    // Assert records exist with correctly computed statuses
    $this->assertDatabaseHas('kpi_results', [
        'kpi_id' => $kpi->id,
        'department_id' => $dept->id,
        'period' => '2025-Q1',
        'actual_value' => 64.0,
        'target_value' => 65.0,
        'baseline_value' => 60.0,
        'status' => 'On Track', // 64 / 65 = 98.4% >= 95% is On Track.
        'notes' => 'Q1 assessment done',
    ]);

    $this->assertDatabaseHas('kpi_results', [
        'kpi_id' => $kpi->id,
        'department_id' => null,
        'period' => '2025-Q2',
        'actual_value' => 66.0,
        'target_value' => 65.0,
        'baseline_value' => 60.0,
        'status' => 'On Track', // 66 / 65 = 101.5% >= 95% (On Track)
        'notes' => 'University-wide result',
    ]);
});

test('import validates missing columns', function () {
    $csvContent = "invalid_header,period,actual_value\n"
                . "UNIV-AC-001,2025-Q1,64.0\n";

    $file = UploadedFile::fake()->createWithContent('invalid.csv', $csvContent);

    $response = $this->post('/kpis/import', [
        'csv_file' => $file
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors('csv_file');
    $this->assertDatabaseEmpty('kpi_results');
});

test('import validates row constraints and fails transaction', function () {
    $kpi = Kpi::create([
        'measure_code' => 'UNIV-AC-001',
        'measure_name' => 'Graduation Rate',
        'measure_owner' => 'Provost Office',
        'measure_type' => 'Academic Excellence',
        'category' => 'Academic',
        'year_range' => '2025-2026',
        'scope' => 'Institutional',
    ]);

    // CSV has one valid row and one invalid row (KPI code does not exist)
    $csvContent = "measure_code,period,actual_value,target_value,baseline_value,department_code,notes\n"
                . "UNIV-AC-001,2025-Q1,64.0,65.0,60.0,,Good row\n"
                . "UNIV-INVALID,2025-Q1,64.0,65.0,60.0,,Bad row\n";

    $file = UploadedFile::fake()->createWithContent('validation_fail.csv', $csvContent);

    $response = $this->post('/kpis/import', [
        'csv_file' => $file
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('import_errors');
    
    $errors = session('import_errors');
    $this->assertCount(1, $errors);
    $this->assertStringContainsString('Row 3: KPI Code \'UNIV-INVALID\' does not exist', $errors[0]);

    // Database must remain empty because transaction rolls back
    $this->assertDatabaseEmpty('kpi_results');
});
