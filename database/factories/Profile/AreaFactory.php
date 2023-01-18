<?php

declare(strict_types=1);

namespace Database\Factories\Profile;

use App\Models\Area;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $city = City::query()->inRandomOrder()->first();

        return [
            'county_id' => $city->county_id,
            'city_id'   => $city->id,
        ];
    }
}
