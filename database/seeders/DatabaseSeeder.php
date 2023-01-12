<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Area;
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
        User::factory(['email' => 'admin@example.com'])
            ->withProfile()
            ->create();
        County::factory(1)->create();
        City::factory(1)->create();
        $this->run([ProfileSeeder::class]);
    }
}
