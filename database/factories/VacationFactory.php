<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\VacationType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacation>
 */
class VacationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::createFromInterface(fake()->dateTimeBetween('-1 week', '5 weeks'));

        return [
            'type' => fake()->randomElement(VacationType::cases()),
            'start_date' => $date->toDateString(),
            'end_date' => $date
                ->addDays(fake()->numberBetween(1, 10))
                ->toDateString(),
            'notes' => fake()->paragraphs(asText: true),
        ];
    }
}
