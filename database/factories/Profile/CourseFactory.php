<?php

declare(strict_types=1);

namespace Database\Factories\Profile;

use App\Enums\CourseType;
use App\Models\Profile\Course;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $endDate = Carbon::parse(fake()->date());
        $startDate = $endDate->subMonths(fake()->randomDigitNotZero());

        return [
            'name'       => fake()->sentence(),
            'theme'      => fake()->sentence(),
            'provider'   => fake()->company(),
            'type'       => fake()->randomElement(CourseType::values()),
            'credits'    => fake()->randomNumber(3),
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ];
    }
}
