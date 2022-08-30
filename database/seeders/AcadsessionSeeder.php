<?php

namespace Database\Seeders;

use App\Models\Acadsession;
use Illuminate\Database\Seeder;

class AcadsessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acadsession::create([
            'name' => '2020/2021',
            'current' => 0,
        ]);

        Acadsession::create([
            'name' => '2021/2022',
            'current' => 1,
        ]);
    }
}
