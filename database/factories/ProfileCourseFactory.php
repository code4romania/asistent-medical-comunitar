<?php

namespace Database\Factories;

use App\Enums\CourseType;
use App\Models\ProfileCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfileCourse>
 */
class ProfileCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = ['Curs de prim ajutor', 'Curs de interventie in caz de accident rutier', 'Curs de interventie avalansa'];
        $providers = ['Dsp Iasi', 'MS', 'Crucea Rosie Brasov', 'Spitalul Maria Iasi'];
        return [
            'year' => fake()->year(),
            'name' => fake()->randomElement($names),
            'provider' =>fake()->randomElement($providers),
            'type' => fake()->randomElement(CourseType::values()),
            'credits' => fake()->randomNumber(3),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),

        ];
    }
}
