<?php

namespace Database\Seeders;

use App\Models\OutreachProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OutreachProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'program_name' => 'Project e-Aral: Digital Literacy for Barangay Children',
                'program_type' => 'Education',
                'implementing_unit' => 'College of Computer Studies',
                'academic_year' => '2025-2026',
                'description' => 'A weekly coding and basic computer operations workshop for children in marginalized communities.',
                'target_community' => 'Barangay 12-A Youth Organization',
                'location' => 'Community Center, Barangay 12-A',
                'partner_agencies' => 'Department of Social Welfare and Development (DSWD), Rotary Club Metro',
                'beneficiaries_count' => 60,
                'start_date' => Carbon::parse('2025-09-06'),
                'end_date' => Carbon::parse('2025-11-29'),
                'status' => 'Completed',
                'outcomes' => 'Successfully trained 60 grade school students in scratch programming and basic digital navigation. Donated 10 refurbished computers.',
                'challenges' => 'Unstable internet connectivity at the community center and irregular attendance due to weather.',
                'recommendations' => 'Provide offline training modules and coordinate with local transport volunteers.',
                'program_coordinator' => 'Prof. Jaime Flores',
                'item_author' => 'Prof. Jaime Flores (Extension Coordinator)',
                'date' => Carbon::parse('2025-12-05'),
            ],
            [
                'program_name' => 'Mobile Health and Wellness Mission',
                'program_type' => 'Health',
                'implementing_unit' => 'College of Nursing and Allied Health',
                'academic_year' => '2025-2026',
                'description' => 'Comprehensive medical check-up, vaccination drive, and nutrition counseling for senior citizens and infants.',
                'target_community' => 'Seniors and Indigent Families',
                'location' => 'Sitio Pag-asa Covered Court',
                'partner_agencies' => 'City Health Office, Red Cross Local Chapter',
                'beneficiaries_count' => 350,
                'start_date' => Carbon::parse('2025-10-12'),
                'end_date' => Carbon::parse('2025-10-14'),
                'status' => 'Completed',
                'outcomes' => 'Delivered vaccinations to 120 toddlers, checked vital health stats for 230 senior citizens, and distributed food packs.',
                'challenges' => 'Insufficient supply of specific maintenance medicines requested by senior citizens.',
                'recommendations' => 'Secure larger sponsorship allocations from pharmaceutical partners beforehand.',
                'program_coordinator' => 'Dr. Karen Lopez',
                'item_author' => 'Maria Victoria Reyes (Nursing Department Liaison)',
                'date' => Carbon::parse('2025-10-20'),
            ],
            [
                'program_name' => 'Eco-Bricks Livelihood Program',
                'program_type' => 'Livelihood',
                'implementing_unit' => 'College of Business Administration',
                'academic_year' => '2025-2026',
                'description' => 'Training housewives and unemployed community members to create decorative tiles and bricks from recycled plastics.',
                'target_community' => 'Barangay San Jose Women’s Association',
                'location' => 'Barangay San Jose Multipurpose Hall',
                'partner_agencies' => 'Department of Trade and Industry (DTI), GreenEarth Eco Foundation',
                'beneficiaries_count' => 45,
                'start_date' => Carbon::parse('2025-08-01'),
                'end_date' => Carbon::parse('2026-03-31'),
                'status' => 'Ongoing',
                'outcomes' => 'Produced over 1,200 bricks, with initial sales generating PHP 18,000 for the women’s cooperative.',
                'challenges' => 'Consistency in plastic segregation and curing times during rainy days.',
                'recommendations' => 'Build a drying shed and purchase a mechanical plastic shredder.',
                'program_coordinator' => 'Dr. Andrew Sy',
                'item_author' => 'Dr. Andrew Sy (Outreach Coordinator)',
                'date' => Carbon::parse('2025-08-15'),
            ],
            [
                'program_name' => 'Cooperative Capacity Building Program',
                'program_type' => 'Partnership',
                'implementing_unit' => 'School of Economics and Social Sciences',
                'academic_year' => '2025-2026',
                'description' => 'Seminars on financial management, bookkeeping, and organizational governance for newly-established agricultural cooperatives.',
                'target_community' => 'Mountain Province Organic Farmers Cooperative',
                'location' => 'La Trinidad Hall',
                'partner_agencies' => 'Cooperative Development Authority (CDA)',
                'beneficiaries_count' => 25,
                'start_date' => Carbon::parse('2026-02-05'),
                'end_date' => Carbon::parse('2026-04-10'),
                'status' => 'Planned',
                'outcomes' => 'Pending kickoff. Curriculums and modules have been pre-approved.',
                'challenges' => 'Scheduling conflicts due to harvesting seasons.',
                'recommendations' => 'Conduct sessions late in the afternoon or during weekend rest days.',
                'program_coordinator' => 'Lorna M. Gabriel',
                'item_author' => 'Lorna M. Gabriel (Lead Faculty)',
                'date' => Carbon::parse('2025-11-20'),
            ]
        ];

        foreach ($programs as $data) {
            OutreachProgram::create($data);
        }
    }
}
