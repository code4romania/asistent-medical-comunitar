<?php

declare(strict_types=1);

namespace Database\Factories\Profile;

use App\Enums\StudyType;
use App\Models\City;
use App\Models\Profile\Study;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Study>
 */
class StudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $endYear = fake()->year();
        $startYear = $endYear - fake()->randomDigitNotZero();

        $city = City::query()->inRandomOrder()->first();

        return [
            'name'        => fake()->sentence(),
            'type'        => fake()->randomElement(StudyType::values()),
            'institution' => fake()->company(),
            'duration'    => fake()->boolean() ? fake()->randomDigitNotNull() : null,
            'start_year'  => $startYear,
            'end_year'    => $endYear,
            'county_id'   => $city->county_id,
            'city_id'     => $city->id,
        ];
    }
}
