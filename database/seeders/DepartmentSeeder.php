<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(['name' => 'Biological Sciences', 'college_id' => 1]);
        Department::create(['name' => 'Chemical Sciences', 'college_id' => 1]);
        Department::create(['name' => 'Computer Science', 'college_id' => 1]);
        Department::create(['name' => 'Food Science & Technology', 'college_id' => 1]);
        Department::create(['name' => 'Architecture', 'college_id' => 2]);
        Department::create(['name' => 'Estate Management', 'college_id' => 2]);
        Department::create(['name' => 'Medical Laboratory Science', 'college_id' => 3]);
        Department::create(['name' => 'Nursing Science', 'college_id' => 3]);
        Department::create(['name' => 'Economics', 'college_id' => 4]);
        Department::create(['name' => 'English', 'college_id' => 4]);
        Department::create(['name' => 'History & International Studies', 'college_id' => 4]);
        Department::create(['name' => 'Mass Communication', 'college_id' => 4]);
        Department::create(['name' => 'Philosophy & Religious Studies', 'college_id' => 4]);
        Department::create(['name' => 'Political Sciences', 'college_id' => 4]);
        Department::create(['name' => 'Accounting', 'college_id' => 5]);
        Department::create(['name' => 'Actuarial Sc. & Insurance', 'college_id' => 5]);
        Department::create(['name' => 'Business Administration', 'college_id' => 5]);
        Department::create(['name' => 'Entrepreneurship', 'college_id' => 5]);
        Department::create(['name' => 'Law', 'college_id' => 6]);
    }
}
