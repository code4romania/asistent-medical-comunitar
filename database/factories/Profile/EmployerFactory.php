<?php

declare(strict_types=1);

namespace Database\Factories\Profile;

use App\Enums\EmployerType;
use App\Models\City;
use App\Models\County;
use App\Models\ProfileEmployer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfileEmployer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'       => fake()->company(),
            'type'       => fake()->randomElement(EmployerType::values()),
            'start_date' => fake()->date(),
            'county_id'  => County::factory(),
            'city_id'    => City::factory(),
        ];
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => Carbon::parse($attributes['start_date'])
                ->addMonths(fake()->randomDigitNotNull()),
        ]);
    }

    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => fake()->date(),
            'end_date'   => null,
        ]);
    }

    public function withProject(): static
    {
        return $this->state(fn (array $attributes) => [
            'project' => fake()->sentence(),
        ]);
    }
}
