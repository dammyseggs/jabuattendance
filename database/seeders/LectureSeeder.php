<?php

namespace Database\Seeders;

use App\Models\Lecture;
use Illuminate\Database\Seeder;

class LectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lecture::create([
            'name' => 'Monday CLass',
            'slug' => 'Monday-Class',
            'course_id' => 1,
            'acadsession_id' => 2,
            'department_id' => 3,
            'addinfo' => '',
        ]);

        Lecture::create([
            'name' => 'Law Afternoon',
            'slug' => 'Law-Afternoon',
            'course_id' => 1,
            'acadsession_id' => 2,
            'department_id' => 3,
            'addinfo' => '',
        ]);
    }
}
