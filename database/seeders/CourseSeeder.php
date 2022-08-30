<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Course::create([
            'coursename' => 'Introduction to Computer',
            'coursecode' => 'CSC 111',
            'courselevel' => '100',
            'department_id' => 2,
            'description' => 'General Course',
        ]);


        Course::create([
            'coursename' => 'Introduction to Operating System',
            'coursecode' => 'CSC 114',
            'courselevel' => '100',
            'department_id' => 2,
            'description' => 'For COmputer',
        ]);
        
    }
}
