<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\ProfileCourse;
use App\Models\ProfileEmployer;
use App\Models\ProfileStudy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProfileStudy::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1])
//            ->forUser()
//            ->forCounty()
//            ->forCity()
            ->count(3)
            ->create();

        ProfileCourse::factory(['user_id' => 1])
            ->count(10)
            ->create();

        ProfileEmployer::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1, 'end_date' => now()])->count(3)->create();
        ProfileEmployer::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1])->count(3)->create();
        ProfileEmployer::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1, 'project_name' => 'Proiect ' . Str::createRandomStringsNormally()])->count(3)->create();

        Area::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1])
            ->count(10)
            ->create();
    }
}
