<?php

namespace Database\Factories;

use App\Enums\EmployerType;
use App\Models\ProfileEmployer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfileEmployer>
 */
class ProfileEmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = ['DSP Timisoara', 'Crucea Rosie Iasi', 'Primaria Tomesti', 'Random Ong'];
        return [
            'name'  => fake()->randomElement($names),
            'type'  => fake()->randomElement(EmployerType::values()),
            'start_date' =>fake()->date,
        ];
    }
}
