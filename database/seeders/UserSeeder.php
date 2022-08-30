<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $adminRole = Role::where('name', 'admin')->first();
        $lecturerRole = Role::where('name', 'lecturer')->first();
        $hodRole = Role::where('name', 'hod')->first();



        $course1 = Course::where('coursecode', 'CSC 111')->first();
        $course2 = Course::where('coursecode', 'CSC 114')->first();

        $lecture1 = Lecture::where('name', 'Monday CLass')->first();
        $lecture2 = Lecture::where('name', 'Law Afternoon')->first();

        // $computer = Department::where('name', 'Computer Science')->first();
        // $chemical = Department::where('name', 'Chemical Sciences')->first();

        $admin1 = User::create([
            'staffid' => 'REG/SP/CM/001',
            'title' => 'Mr',
            'name' => 'Olatunde',
            'othername' => 'Babajide Dada',
            'is_admin' => 1,
            'department_id' => 1,
            'email' => 'admin1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $admin2 = User::create([
            'staffid' => 'REG/SP/EN/381',
            'title' => 'Mr',
            'name' => 'Akano',
            'othername' => 'Samuel Bayo',
            'is_admin' => 1,
            'department_id' => 3,
            'email' => 'admin2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $lecturere1 = User::create([
            'staffid' => 'REG/SP/EN/101',
            'title' => 'Mr',
            'name' => 'Ajisafe',
            'othername' => 'Ademola',
            'is_admin' => 0,
            'department_id' => 2,
            'email' => 'lecturere1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $lecturere2 = User::create([
            'staffid' => 'REG/SP/EN/256',
            'title' => 'Mr',
            'name' => 'Akinade',
            'othername' => 'Samuel',
            'is_admin' => 0,
            'department_id' => 2,
            'email' => 'lecturere2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $lecturere3 = User::create([
            'staffid' => 'REG/SP/EN/106',
            'title' => 'Mrs',
            'name' => 'Alaba',
            'othername' => 'Janet',
            'is_admin' => 0,
            'department_id' => 3,
            'email' => 'lecturere3@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $lecturere4 = User::create([
            'staffid' => 'REG/SP/EN/258',
            'title' => 'Mrs',
            'name' => 'Akinade',
            'othername' => 'Samuel',
            'is_admin' => 0,
            'department_id' => 4,
            'email' => 'lecturere4@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $hod1 = User::create([
            'staffid' => 'REG/SP/AC/257',
            'title' => 'Dr',
            'name' => 'Akinmu',
            'othername' => 'Alade Joseph',
            'is_admin' => 0,
            'department_id' => 2,
            'email' => 'hod1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $hod2 = User::create([
            'staffid' => 'REG/SP/HS/211',
            'title' => 'Dr',
            'name' => 'Akintokunbo',
            'othername' => 'Aladeola Janet',
            'is_admin' => 0,
            'department_id' => 2,
            'email' => 'hod2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);


        $admin1->roles()->attach($adminRole);
        $admin2->roles()->attach($adminRole);

        $lecturere1->roles()->attach($lecturerRole);
        $lecturere2->roles()->attach($lecturerRole);
        $lecturere3->roles()->attach($lecturerRole);
        $lecturere4->roles()->attach($lecturerRole);

        $hod1->roles()->attach($hodRole);
        $hod2->roles()->attach($hodRole);

        $lecturere1->courses()->attach($course1);
        $lecturere2->courses()->attach($course2);

        $lecturere1->lectures()->attach($lecture1);
        $lecturere1->lectures()->attach($lecture2);

        // $lecturere1->departments()->attach($computer);
        // $lecturere2->departments()->attach($lecturerRole);



    }
}
