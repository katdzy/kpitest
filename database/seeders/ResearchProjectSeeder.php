<?php

namespace Database\Seeders;

use App\Models\ResearchProject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ResearchProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Development of IoT-Based Precision Agriculture Monitoring System',
                'type' => 'Applied',
                'lead_researcher' => 'Dr. Arnel F. Celestino',
                'academic_year' => '2025-2026',
                'co_researchers' => 'Prof. Mark T. Agbulos, Engr. Lisa Gomez',
                'implementing_unit' => 'Department of Electronics Engineering',
                'funding_source' => 'DOST-PCIEERD',
                'funding_amount' => 1850000.00,
                'status' => 'Ongoing',
                'start_date' => Carbon::parse('2025-07-01'),
                'end_date' => Carbon::parse('2026-06-30'),
                'abstract' => 'This study presents an Internet of Things (IoT) monitoring framework tailored for local strawberry farms. Sensors capture temperature, soil moisture, and pH values in real-time, sending data to a cloud API. A machine learning model processes telemetry to predict irrigation events, improving crop quality and water usage efficiency.',
                'keywords' => 'IoT, Precision Agriculture, Machine Learning, Soil Sensors',
                'output_type' => 'Journal Article',
                'publication_title' => 'International Journal of Agricultural Robotics and Technology',
                'isbn_issn' => '2049-3827',
                'indexed_in' => 'Scopus',
                'doi' => '10.1016/j.ijart.2025.10123',
                'citation_count' => '0',
                'remarks' => 'Prototypes deployed in Benguet local farms. Good initial feedback.',
                'item_author' => 'Dr. Arnel F. Celestino (Lead Researcher)',
                'date' => Carbon::parse('2025-08-10'),
            ],
            [
                'title' => 'Socio-Economic Impact of Renewable Energy Transitions in Coastal Barangays',
                'type' => 'Policy',
                'lead_researcher' => 'Dr. Rowena V. Biazon',
                'academic_year' => '2025-2026',
                'co_researchers' => 'Dr. Jose D. Rellosa',
                'implementing_unit' => 'Center for Social Research and Development',
                'funding_source' => 'University Internal Research Grant',
                'funding_amount' => 350000.00,
                'status' => 'Completed',
                'start_date' => Carbon::parse('2025-01-15'),
                'end_date' => Carbon::parse('2025-09-30'),
                'abstract' => 'An evaluation of solar microgrids installed in three off-grid fishing villages. Focus is placed on changes in household productivity, cost of electricity, and local livelihood shifts post-electrification. Results suggest substantial gains in evening school hours and refrigerated fish storage, though structural policy supports are needed for battery management.',
                'keywords' => 'Renewable Energy, Social Impact, Coastal Communities, Microgrids',
                'output_type' => 'Policy Brief',
                'publication_title' => 'Provincial Legislative Council Policy Papers',
                'isbn_issn' => 'N/A',
                'indexed_in' => 'Local / Institutional',
                'doi' => 'N/A',
                'citation_count' => 'N/A',
                'remarks' => 'Presented to the Provincial Development Council in October 2025. Draft resolution submitted.',
                'item_author' => 'Dr. Rowena V. Biazon (Lead Researcher)',
                'date' => Carbon::parse('2025-10-15'),
            ],
            [
                'title' => 'Synthesis and Characterization of Cellulose Nanocrystals from Agricultural Wastes',
                'type' => 'Basic',
                'lead_researcher' => 'Dr. Mildred C. Hermosa',
                'academic_year' => '2024-2025',
                'co_researchers' => 'Dr. Grace Y. Tan, Ronald C. Sy',
                'implementing_unit' => 'Department of Chemistry',
                'funding_source' => 'CHED DARE-to-Research Grant',
                'funding_amount' => 2450000.00,
                'status' => 'Published',
                'start_date' => Carbon::parse('2024-06-01'),
                'end_date' => Carbon::parse('2025-05-31'),
                'abstract' => 'This project successfully synthesized high-purity cellulose nanocrystals (CNCs) from rice straw and pineapple peelings through acid hydrolysis. X-ray diffraction and transmission electron microscopy confirmed crystalline structures averaging 150 nm in length. These CNCs exhibit high thermal stability, showing high potential as reinforcements in biodegradable plastics.',
                'keywords' => 'Cellulose Nanocrystals, Bioplastics, Nanotechnology, Agricultural Waste',
                'output_type' => 'Journal Article',
                'publication_title' => 'Asia-Pacific Journal of Chemical Engineering and Macromolecules',
                'isbn_issn' => '1934-821X',
                'indexed_in' => 'ISI Web of Science',
                'doi' => '10.1002/apj.2025.556',
                'citation_count' => '8',
                'remarks' => 'Journal published in August 2025 issue. Patent application for extraction process is ongoing.',
                'item_author' => 'Dr. Mildred C. Hermosa (Professor of Chemistry)',
                'date' => Carbon::parse('2025-09-01'),
            ],
            [
                'title' => 'An Interactive Gamified Language App for Indigenous Language Preservation',
                'type' => 'Development',
                'lead_researcher' => 'Prof. Samuel K. Pineda',
                'academic_year' => '2025-2026',
                'co_researchers' => 'Prof. Katrina Alcantara (Linguistics Dept)',
                'implementing_unit' => 'College of Arts and Humanities',
                'funding_source' => 'National Commission for Culture and the Arts (NCCA)',
                'funding_amount' => 800000.00,
                'status' => 'Proposed',
                'start_date' => null,
                'end_date' => null,
                'abstract' => 'Project aims to design a mobile application containing lessons, quizzes, and vocabulary exercises for learning the endangered Kankana-ey dialect. The design integrates gamified progression mechanics to engage younger generations.',
                'keywords' => 'Language Preservation, Gamification, EdTech, Indigenous Dialects',
                'output_type' => 'Conference Paper',
                'publication_title' => 'Joint Conference on Digital Humanities and Linguistics (JCDHL 2026)',
                'isbn_issn' => null,
                'indexed_in' => 'Pending',
                'doi' => null,
                'citation_count' => '0',
                'remarks' => 'Proposal approved for NCCA funding. Awaiting initial tranche release.',
                'item_author' => 'Prof. Samuel K. Pineda (Lead Developer)',
                'date' => Carbon::parse('2025-11-01'),
            ]
        ];

        foreach ($projects as $data) {
            ResearchProject::create($data);
        }
    }
}
