<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
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
            'date' => $date->toDateString(),
            'start_time' => $date->toTimeString(),
            'end_time' => $date
                ->addUnitNoOverflow('hour', fake()->numberBetween(1, 4), 'day')
                ->toTimeString(),

            'type' => fake()->word(),
            'location' => fake()->word(),
            'attendant' => fake()->word(),

            'notes' => fake()->paragraphs(asText: true),

            'beneficiary_id' => Beneficiary::factory(),
            'nurse_id' => User::factory(),
        ];
    }
}
