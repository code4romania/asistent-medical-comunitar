<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\County;
use App\Models\ProfileCourse;
use App\Models\ProfileEmployer;
use App\Models\ProfileStudy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin
        $user = User::factory(['email' => 'admin@example.com'])
            ->withProfile()
            ->create();
        $county = County::factory(1)->create();
        $city = City::factory(1)->create();

        ProfileStudy::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1])
//            ->forUser()
//            ->forCounty()
//            ->forCity()
            ->count(3)
            ->create();

        ProfileCourse::factory(['user_id' => 1])
            ->count(10)
            ->create();

        ProfileEmployer::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1, 'end_date'=>now()])->count(3)->create();

        ProfileEmployer::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1])->count(3)->create();
        ProfileEmployer::factory(['user_id' => 1, 'county_id' => 1, 'city_id' => 1, 'project_name'=>'Proiect '. Str::createRandomStringsNormally()])->count(3)->create();
    }
}
