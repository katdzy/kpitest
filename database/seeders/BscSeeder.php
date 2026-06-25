<?php

namespace Database\Seeders;

use App\Models\Objective;
use App\Models\Perspective;
use Illuminate\Database\Seeder;

class BscSeeder extends Seeder
{
    public function run(): void
    {
        // ── 4 BSC Perspectives ─────────────────────────────────────────
        $perspectives = [
            [
                'name'        => 'Customer & Stakeholder',
                'color'       => 'blue',
                'hex_color'   => '#2563eb',
                'description' => 'Focuses on delivering value and satisfaction to students, graduates, parents, employers, and the wider community.',
                'order'       => 1,
            ],
            [
                'name'        => 'Sustainability',
                'color'       => 'emerald',
                'hex_color'   => '#059669',
                'description' => 'Ensures the institution maintains financial health, responsible resource use, and a strong public image to sustain operations long-term.',
                'order'       => 2,
            ],
            [
                'name'        => 'Internal Process',
                'color'       => 'orange',
                'hex_color'   => '#ea580c',
                'description' => 'Focuses on the operational processes, infrastructure, and systems that enable the institution to deliver quality outcomes efficiently.',
                'order'       => 3,
            ],
            [
                'name'        => 'Learning & Growth',
                'color'       => 'violet',
                'hex_color'   => '#7c3aed',
                'description' => 'Develops the people, digital capabilities, and scholarly knowledge needed to drive institutional advancement.',
                'order'       => 4,
            ],
        ];

        $createdPerspectives = [];
        foreach ($perspectives as $p) {
            $createdPerspectives[$p['name']] = Perspective::firstOrCreate(['name' => $p['name']], $p);
        }

        // ── 15 BSC Strategic Objectives ────────────────────────────────
        $cs   = $createdPerspectives['Customer & Stakeholder']->id;
        $sus  = $createdPerspectives['Sustainability']->id;
        $ip   = $createdPerspectives['Internal Process']->id;
        $lg   = $createdPerspectives['Learning & Growth']->id;

        $objectives = [
            // Customer & Stakeholder
            [
                'perspective_id'  => $cs,
                'code'            => 'O1',
                'title'           => 'Improve Customer & Stakeholder Satisfaction',
                'intended_result' => 'HAU has become known for its memorable student and stakeholder experience and increased satisfaction through the effective teaching and learning strategies, rendered by motivated employees.',
                'owner'           => 'CG',
                'order'           => 1,
            ],
            [
                'perspective_id'  => $cs,
                'code'            => 'O2',
                'title'           => 'Improve Graduate Competitiveness',
                'intended_result' => 'Achievement of high-level graduate attributes that speaks of better performance in licensure examinations, career placement, and employer satisfaction.',
                'owner'           => 'AAO',
                'order'           => 2,
            ],
            [
                'perspective_id'  => $cs,
                'code'            => 'O3',
                'title'           => 'Improve Academic Quality',
                'intended_result' => 'HAU is recognized for its extraordinary academic design and student experiences based on high-impact educational practices, instructional effectiveness, and service excellence.',
                'owner'           => 'AAO, OIA, SSAC',
                'order'           => 3,
            ],
            [
                'perspective_id'  => $cs,
                'code'            => 'O4',
                'title'           => 'Intensify Collaboration & Partnerships',
                'intended_result' => 'HAU has intensified strategic alliances with local and international partners for career development and internships, research collaboration, and social advocacies.',
                'owner'           => 'AAO, OIA, CFSI, SSAC',
                'order'           => 4,
            ],
            [
                'perspective_id'  => $cs,
                'code'            => 'O5',
                'title'           => 'Increase Community Engagement',
                'intended_result' => 'Improved volunteer development and engagement toward collaborative partnership for innovative community-building.',
                'owner'           => 'CG',
                'order'           => 5,
            ],
            // Sustainability
            [
                'perspective_id'  => $sus,
                'code'            => 'O6',
                'title'           => 'Strengthen Financial Viability',
                'intended_result' => 'HAU has taken decisions and responsible actions for environmental viability, economic viability, and a just society, for present and future generations, while respecting cultural diversity.',
                'owner'           => 'FRMS',
                'order'           => 6,
            ],
            [
                'perspective_id'  => $sus,
                'code'            => 'O7',
                'title'           => 'Improve Social & Environmental Stewardship',
                'intended_result' => 'Generation of sufficient revenue to sustain operational and academic requirements and, where applicable, to slow growth while maintaining service levels.',
                'owner'           => 'OTMI',
                'order'           => 7,
            ],
            [
                'perspective_id'  => $sus,
                'code'            => 'O8',
                'title'           => 'Improve Image & Branding',
                'intended_result' => "HAU's institutional brand and reputation are recognized, as it builds familiarity, trust, and preference, resulting in increased first-choice enrollment, community partnerships, and organizational sustainability.",
                'owner'           => 'MCS',
                'order'           => 8,
            ],
            // Internal Process
            [
                'perspective_id'  => $ip,
                'code'            => 'O9',
                'title'           => 'Update Facilities & Resources',
                'intended_result' => 'Continuous improvement of overall physical and psychosocial environments that enable the delivery of excellent services and safe work and learning space.',
                'owner'           => 'CSDO, AAO, ITSS',
                'order'           => 9,
            ],
            [
                'perspective_id'  => $ip,
                'code'            => 'O10',
                'title'           => 'Improve Process Environment',
                'intended_result' => 'Improved management system for monitoring, evaluating, and reporting employees\' performance, including a team working collaboratively on departmental goals.',
                'owner'           => 'CG',
                'order'           => 10,
            ],
            [
                'perspective_id'  => $ip,
                'code'            => 'O11',
                'title'           => 'Enhance Performance Management',
                'intended_result' => 'HAU is distinguished for its highly committed and empowered employees that uphold and exemplify Catholic ideals and promoting Catholic values.',
                'owner'           => 'ITEC, CG',
                'order'           => 11,
            ],
            [
                'perspective_id'  => $ip,
                'code'            => 'O12',
                'title'           => 'Strengthen Character & Identity',
                'intended_result' => 'Employees are equipped with the digital skills necessary for service delivery and responsiveness. The performance gap in academic and managerial technologies is closed to enable the attainment of strategic goals.',
                'owner'           => 'ICFSI',
                'order'           => 12,
            ],
            // Learning & Growth
            [
                'perspective_id'  => $lg,
                'code'            => 'O13',
                'title'           => 'Improve Digital Competencies',
                'intended_result' => 'Employees are equipped with the digital skills necessary for service delivery and responsiveness.',
                'owner'           => 'IDMO, ITSS',
                'order'           => 13,
            ],
            [
                'perspective_id'  => $lg,
                'code'            => 'O14',
                'title'           => 'Improve Professional Competencies',
                'intended_result' => 'Improvement of learning and teaching methodology effectiveness to guide students in achieving degrees and careers.',
                'owner'           => 'HRMO, ITEC, IDMO',
                'order'           => 14,
            ],
            [
                'perspective_id'  => $lg,
                'code'            => 'O15',
                'title'           => 'Enhance Scholarly Works',
                'intended_result' => 'Improvement of learning and teaching methodology effectiveness to assist students in achieving degrees and careers.',
                'owner'           => 'URO',
                'order'           => 15,
            ],
        ];

        foreach ($objectives as $obj) {
            Objective::firstOrCreate(['code' => $obj['code']], $obj);
        }

        $this->command->info('✅ BSC seeder complete: 4 perspectives + 15 objectives seeded.');
    }
}
