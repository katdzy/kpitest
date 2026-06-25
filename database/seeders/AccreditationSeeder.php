<?php

namespace Database\Seeders;

use App\Models\Accreditation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AccreditationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accreditations = [
            [
                'program_name' => 'Bachelor of Science in Computer Science',
                'level' => 'Program',
                'accrediting_body' => 'PAASCU',
                'academic_year' => '2025-2026',
                'accreditation_level' => 'Level III Reaccredited',
                'status' => 'Active',
                'validity_start' => Carbon::parse('2023-11-15'),
                'validity_end' => Carbon::parse('2028-11-14'),
                'certifying_officer' => 'Dr. Conchita L. Miranda',
                'college_department' => 'College of Computer Studies',
                'last_survey_date' => Carbon::parse('2023-10-10'),
                'next_survey_date' => Carbon::parse('2028-10-10'),
                'survey_visit_count' => 3,
                'conditions' => 'Must submit a progress report on library resource expansion and lab facility upgrades by year 3.',
                'remarks' => 'Highly commended for strong industry placement partnerships.',
                'focal_person' => 'Dean Rodolfo Valenzuela',
                'item_author' => 'Dean Rodolfo Valenzuela (Dean, CCS)',
                'date' => Carbon::parse('2023-11-20'),
            ],
            [
                'program_name' => 'Bachelor of Secondary Education',
                'level' => 'Program',
                'accrediting_body' => 'AACCUP',
                'academic_year' => '2025-2026',
                'accreditation_level' => 'Level IV Candidate',
                'status' => 'Pending',
                'validity_start' => null,
                'validity_end' => null,
                'certifying_officer' => 'Dr. Orlando M. Gose',
                'college_department' => 'College of Teacher Education',
                'last_survey_date' => Carbon::parse('2025-05-18'),
                'next_survey_date' => Carbon::parse('2026-05-18'),
                'survey_visit_count' => 4,
                'conditions' => 'Requires higher proportion of faculty with doctorate degrees.',
                'remarks' => 'Visit took place in May; currently waiting for the formal board resolution.',
                'focal_person' => 'Dr. Teresita Gomez',
                'item_author' => 'Dr. Teresita Gomez (CTE Quality Head)',
                'date' => Carbon::parse('2025-06-01'),
            ],
            [
                'program_name' => 'University-Wide ISO 9001:2015 Certification',
                'level' => 'Institutional',
                'accrediting_body' => 'ISO / TÜV SÜD',
                'academic_year' => '2025-2026',
                'accreditation_level' => 'ISO Certified',
                'status' => 'Active',
                'validity_start' => Carbon::parse('2024-04-01'),
                'validity_end' => Carbon::parse('2027-03-31'),
                'certifying_officer' => 'Dir. Rainer Schmidt',
                'college_department' => 'Central Administration',
                'last_survey_date' => Carbon::parse('2024-03-15'),
                'next_survey_date' => Carbon::parse('2026-03-15'), // Surveillance audit
                'survey_visit_count' => 2,
                'conditions' => 'None. Satisfactory compliance across all functional management sections.',
                'remarks' => 'Surveillance audit schedule set for mid-March 2026.',
                'focal_person' => 'Atty. Grace Beltran (VP Quality Assurance)',
                'item_author' => 'Atty. Grace Beltran (VP QA)',
                'date' => Carbon::parse('2024-04-10'),
            ],
            [
                'program_name' => 'Master of Business Administration',
                'level' => 'Program',
                'accrediting_body' => 'PAASCU',
                'academic_year' => '2024-2025',
                'accreditation_level' => 'Level II Accredited',
                'status' => 'Active',
                'validity_start' => Carbon::parse('2020-03-01'),
                'validity_end' => Carbon::parse('2025-02-28'),
                'certifying_officer' => 'Dr. Conchita L. Miranda',
                'college_department' => 'Graduate School of Business',
                'last_survey_date' => Carbon::parse('2020-02-10'),
                'next_survey_date' => Carbon::parse('2025-02-10'),
                'survey_visit_count' => 2,
                'conditions' => 'Strengthen graduate research publications output.',
                'remarks' => 'Currently preparing the self-survey report for reaccreditation in 2026 due to extension.',
                'focal_person' => 'Dr. Fernando Lopez',
                'item_author' => 'Dr. Fernando Lopez (GS Dean)',
                'date' => Carbon::parse('2020-03-15'),
            ]
        ];

        foreach ($accreditations as $data) {
            Accreditation::create($data);
        }
    }
}
