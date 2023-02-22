<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Family;
use App\Models\Household;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Family>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->lastName(),
            'household_id' => Household::factory(),
        ];
    }
}
