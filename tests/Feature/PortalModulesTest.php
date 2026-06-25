<?php

use App\Models\Scholarship;
use App\Models\OutreachProgram;
use App\Models\Accreditation;
use App\Models\ResearchProject;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('scholarships crud operations', function () {
    // 1. Create
    $data = [
        'title' => 'Test Scholarship',
        'type' => 'Scholarship',
        'beneficiary_type' => 'Student',
        'academic_year' => '2025-2026',
        'description' => 'Test description',
        'amount' => 100000,
        'status' => 'Active',
    ];
    $response = $this->post('/scholarships', $data);
    $this->assertDatabaseHas('scholarships', ['title' => 'Test Scholarship']);
    $scholarship = Scholarship::first();
    $response->assertRedirect("/scholarships/{$scholarship->id}");

    // 2. Read
    $response = $this->get("/scholarships/{$scholarship->id}");
    $response->assertStatus(200);
    $response->assertSee('Test Scholarship');

    // 3. Update
    $updateData = array_merge($data, ['title' => 'Updated Scholarship']);
    $response = $this->put("/scholarships/{$scholarship->id}", $updateData);
    $response->assertRedirect("/scholarships/{$scholarship->id}");
    $this->assertDatabaseHas('scholarships', ['title' => 'Updated Scholarship']);

    // 4. Delete
    $response = $this->delete("/scholarships/{$scholarship->id}");
    $response->assertRedirect('/scholarships');
    $this->assertDatabaseMissing('scholarships', ['id' => $scholarship->id]);
});

test('outreach programs crud operations', function () {
    // 1. Create
    $data = [
        'program_name' => 'Test Outreach',
        'program_type' => 'Community',
        'implementing_unit' => 'College of Science',
        'academic_year' => '2025-2026',
        'description' => 'Test description',
        'status' => 'Planned',
    ];
    $response = $this->post('/outreach', $data);
    $this->assertDatabaseHas('outreach_programs', ['program_name' => 'Test Outreach']);
    $outreach = OutreachProgram::first();
    $response->assertRedirect("/outreach/{$outreach->id}");

    // 2. Read
    $response = $this->get("/outreach/{$outreach->id}");
    $response->assertStatus(200);
    $response->assertSee('Test Outreach');

    // 3. Update
    $updateData = array_merge($data, ['program_name' => 'Updated Outreach']);
    $response = $this->put("/outreach/{$outreach->id}", $updateData);
    $response->assertRedirect("/outreach/{$outreach->id}");
    $this->assertDatabaseHas('outreach_programs', ['program_name' => 'Updated Outreach']);

    // 4. Delete
    $response = $this->delete("/outreach/{$outreach->id}");
    $response->assertRedirect('/outreach');
    $this->assertDatabaseMissing('outreach_programs', ['id' => $outreach->id]);
});

test('accreditations crud operations', function () {
    // 1. Create
    $data = [
        'program_name' => 'Test Accreditation',
        'level' => 'Program',
        'accrediting_body' => 'PAASCU',
        'academic_year' => '2025-2026',
        'status' => 'Active',
    ];
    $response = $this->post('/accreditations', $data);
    $this->assertDatabaseHas('accreditations', ['program_name' => 'Test Accreditation']);
    $accreditation = Accreditation::first();
    $response->assertRedirect("/accreditations/{$accreditation->id}");

    // 2. Read
    $response = $this->get("/accreditations/{$accreditation->id}");
    $response->assertStatus(200);
    $response->assertSee('Test Accreditation');

    // 3. Update
    $updateData = array_merge($data, ['program_name' => 'Updated Accreditation']);
    $response = $this->put("/accreditations/{$accreditation->id}", $updateData);
    $response->assertRedirect("/accreditations/{$accreditation->id}");
    $this->assertDatabaseHas('accreditations', ['program_name' => 'Updated Accreditation']);

    // 4. Delete
    $response = $this->delete("/accreditations/{$accreditation->id}");
    $response->assertRedirect('/accreditations');
    $this->assertDatabaseMissing('accreditations', ['id' => $accreditation->id]);
});

test('research projects crud operations', function () {
    // 1. Create
    $data = [
        'title' => 'Test Research Project',
        'type' => 'Applied',
        'lead_researcher' => 'Dr. Test Researcher',
        'academic_year' => '2025-2026',
        'status' => 'Ongoing',
    ];
    $response = $this->post('/research', $data);
    $this->assertDatabaseHas('research_projects', ['title' => 'Test Research Project']);
    $research = ResearchProject::first();
    $response->assertRedirect("/research/{$research->id}");

    // 2. Read
    $response = $this->get("/research/{$research->id}");
    $response->assertStatus(200);
    $response->assertSee('Test Research Project');

    // 3. Update
    $updateData = array_merge($data, ['title' => 'Updated Research Project']);
    $response = $this->put("/research/{$research->id}", $updateData);
    $response->assertRedirect("/research/{$research->id}");
    $this->assertDatabaseHas('research_projects', ['title' => 'Updated Research Project']);

    // 4. Delete
    $response = $this->delete("/research/{$research->id}");
    $response->assertRedirect('/research');
    $this->assertDatabaseMissing('research_projects', ['id' => $research->id]);
});
