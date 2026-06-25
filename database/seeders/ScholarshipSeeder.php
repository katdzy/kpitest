<?php

namespace Database\Seeders;

use App\Models\Scholarship;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ScholarshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scholarships = [
            [
                'title' => 'Presidents Academic Excellence Scholarship',
                'type' => 'Scholarship',
                'beneficiary_type' => 'Student',
                'academic_year' => '2025-2026',
                'description' => 'Full tuition and stipend for top 10% performing undergraduate students in engineering and sciences.',
                'funding_source' => 'University Endowment Fund',
                'administering_unit' => 'Office of Admissions and Scholarships',
                'amount' => 2500000.00,
                'currency' => 'PHP',
                'beneficiaries_count' => 150,
                'selection_criteria' => 'GPA >= 3.75, active participation in extracurriculars',
                'start_date' => Carbon::parse('2025-08-01'),
                'end_date' => Carbon::parse('2026-05-31'),
                'status' => 'Active',
                'outcomes' => 'Supported 150 elite scholars, resulting in 98% retention and 45 honor graduates.',
                'remarks' => 'Funding increased by 10% from the previous academic year.',
                'item_author' => 'Maria Santos (Scholarship Coordinator)',
                'date' => Carbon::parse('2025-07-15'),
            ],
            [
                'title' => 'Department of Science and Technology (DOST) ASTHRDP Grant',
                'type' => 'Grant',
                'beneficiary_type' => 'Student',
                'academic_year' => '2025-2026',
                'description' => 'Accelerated Science and Technology Human Resource Development Program for MS/PhD scholars.',
                'funding_source' => 'DOST-SEI',
                'administering_unit' => 'School of Science and Engineering',
                'amount' => 5800000.00,
                'currency' => 'PHP',
                'beneficiaries_count' => 45,
                'selection_criteria' => 'Pass DOST qualifying exam, enrolled in priority science courses',
                'start_date' => Carbon::parse('2025-08-15'),
                'end_date' => Carbon::parse('2026-06-30'),
                'status' => 'Active',
                'outcomes' => 'Enables research in biotechnology, materials science, and advanced computing.',
                'remarks' => 'Direct transfer from DOST regional office.',
                'item_author' => 'Dr. Manuel Cruz (Graduate School Dean)',
                'date' => Carbon::parse('2025-08-01'),
            ],
            [
                'title' => 'Faculty Research and Development Fellowship',
                'type' => 'Fellowship',
                'beneficiary_type' => 'Faculty',
                'academic_year' => '2024-2025',
                'description' => 'Defrays cost of local/foreign study leave for faculty pursuing doctoral degrees.',
                'funding_source' => 'Institutional Faculty Development Fund',
                'administering_unit' => 'Human Resource Management and Development Office',
                'amount' => 1200000.00,
                'currency' => 'PHP',
                'beneficiaries_count' => 8,
                'selection_criteria' => 'Tenured faculty, accepted into CHED-aligned university',
                'start_date' => Carbon::parse('2024-06-01'),
                'end_date' => Carbon::parse('2025-05-31'),
                'status' => 'Completed',
                'outcomes' => 'Three faculty members successfully completed their PhDs and returned to active service.',
                'remarks' => 'All fellows submitted progress reports and return service contracts.',
                'item_author' => 'Elena Perez (HR Director)',
                'date' => Carbon::parse('2024-05-15'),
            ],
            [
                'title' => 'Graduate Teaching Assistantship Program',
                'type' => 'Assistantship',
                'beneficiary_type' => 'Student',
                'academic_year' => '2025-2026',
                'description' => 'Provides monthly stipends and tuition waivers to graduate students assisting in undergraduate lab courses.',
                'funding_source' => 'University Operations Budget',
                'administering_unit' => 'Office of the Vice President for Academic Affairs',
                'amount' => 950000.00,
                'currency' => 'PHP',
                'beneficiaries_count' => 20,
                'selection_criteria' => 'Graduate student in good standing, recommendation from Dept Chair',
                'start_date' => Carbon::parse('2025-09-01'),
                'end_date' => Carbon::parse('2026-06-15'),
                'status' => 'Active',
                'outcomes' => 'Assists department faculty in teaching load, providing financial security to graduate researchers.',
                'remarks' => 'Assigned to College of Science (12 TAs) and College of Engineering (8 TAs).',
                'item_author' => 'Dr. Elizabeth Vance (Provost)',
                'date' => Carbon::parse('2025-08-20'),
            ],
            [
                'title' => 'Socio-Economic Relief Grant (SERG)',
                'type' => 'Grant',
                'beneficiary_type' => 'Both',
                'academic_year' => '2025-2026',
                'description' => 'Financial assistance program for students and administrative staff affected by natural calamities/disasters.',
                'funding_source' => 'Calamity and Relief Fund',
                'administering_unit' => 'Social Action Center',
                'amount' => 450000.00,
                'currency' => 'PHP',
                'beneficiaries_count' => 90,
                'selection_criteria' => 'Reside in declared calamity areas, proof of structural damage',
                'start_date' => Carbon::parse('2025-11-01'),
                'end_date' => Carbon::parse('2026-03-31'),
                'status' => 'Pending',
                'outcomes' => 'Awaiting board approval for allocation adjustment.',
                'remarks' => 'Target release by December 2025.',
                'item_author' => 'Bro. Alberto Diaz (Social Action Director)',
                'date' => Carbon::parse('2025-10-15'),
            ]
        ];

        foreach ($scholarships as $data) {
            Scholarship::create($data);
        }
    }
}
