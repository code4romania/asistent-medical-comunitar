<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\County;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->city(),
            'county_id' => County::factory(),
        ];
    }
}
