<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'matric_no' => '1802345970',
            'name' => 'Akinwole',
            'othername' => 'Janet Dada',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 2,
        ]);

        Student::create([
            'matric_no' => '180345670',
            'name' => 'Oloyede',
            'othername' => 'Opeyemi Oluwatosin',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 2,
        ]);

        Student::create([
            'matric_no' => 'C18056009123',
            'name' => 'Aluko',
            'othername' => 'David Opeyemi',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 2,
        ]);

        Student::create([
            'matric_no' => 'C18056009124',
            'name' => 'Nyong',
            'othername' => 'Daniel Bernard',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 2,
        ]);

        Student::create([
            'matric_no' => '1802345989',
            'name' => 'Adeleke',
            'othername' => 'Ifeoluwa Esther',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 1,
        ]);

        Student::create([
            'matric_no' => '180345000',
            'name' => 'Popoola',
            'othername' => 'Tomilola Oluwadasola',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 1,
        ]);

        Student::create([
            'matric_no' => 'C18056009123',
            'name' => 'Olunloyo',
            'othername' => 'Josephine Oluwa0pamilerin',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 2,
        ]);

        Student::create([
            'matric_no' => '19087652000',
            'name' => 'Falaye',
            'othername' => 'Daniel Adedamola',
            'stdlevel' => '100',
            'department_id' => 2,
            'acadsession_id' => 1,
        ]);
    }
}
