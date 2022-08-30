<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AcadsessionSeeder::class,
            RoleSeeder::class,
            CollegeSeeder::class,
            DepartmentSeeder::class,
            CourseSeeder::class,
            LectureSeeder::class,
            StudentSeeder::class,
            UserSeeder::class,
        ]);
        //\App\Models\Role::factory()->hasUsers(5)->create();
    }
}
