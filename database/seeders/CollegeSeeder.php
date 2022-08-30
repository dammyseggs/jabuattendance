<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        College::create(['name' => 'College of Agriculture and Natural Sciences']);
        College::create(['name' => 'College of Environmental Sciences']);
        College::create(['name' => 'College of Health Sciences']);
        College::create(['name' => 'College of Humanities and Social Sciences']);
        College::create(['name' => 'College of Management Sciences']);
        College::create(['name' => 'College of Law']);
    }
}
