<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'College of Engineering',
                'code' => 'COE',
                'description' => 'Department managing engineering disciplines including Computer, Mechanical, Electrical, Civil, and Chemical Engineering.',
                'college' => 'Engineering and Technology',
                'is_active' => true,
            ],
            [
                'name' => 'College of Arts and Sciences',
                'code' => 'CAS',
                'description' => 'Department managing humanities, natural sciences, and social sciences.',
                'college' => 'Arts and Sciences',
                'is_active' => true,
            ],
            [
                'name' => 'College of Business Administration',
                'code' => 'CBA',
                'description' => 'Department managing business, finance, accounting, and marketing courses.',
                'college' => 'Business',
                'is_active' => true,
            ],
            [
                'name' => 'College of Medicine',
                'code' => 'COM',
                'description' => 'Department managing medical education and clinical research programs.',
                'college' => 'Health Sciences',
                'is_active' => true,
            ],
            [
                'name' => 'College of Nursing',
                'code' => 'CON',
                'description' => 'Department managing nursing education and clinical healthcare instruction.',
                'college' => 'Health Sciences',
                'is_active' => true,
            ],
            [
                'name' => 'School of Graduate Studies',
                'code' => 'SGS',
                'description' => 'Department overseeing master and doctoral research programs across disciplines.',
                'college' => 'Graduate Studies',
                'is_active' => true,
            ],
            [
                'name' => 'Office of Academic Affairs',
                'code' => 'OAA',
                'description' => 'Administrative office overseeing curricula, faculty affairs, and registrar duties.',
                'college' => 'Administration',
                'is_active' => true,
            ],
            [
                'name' => 'Office of Research and Innovation',
                'code' => 'ORI',
                'description' => 'Administrative office overseeing sponsored projects, research integrity, and commercialization.',
                'college' => 'Administration',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(['code' => $dept['code']], $dept);
        }
    }
}
