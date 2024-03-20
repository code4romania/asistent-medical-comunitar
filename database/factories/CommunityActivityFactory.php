<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CommunityActivityType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommunityActivity>
 */
class CommunityActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(CommunityActivityType::cases());

        if (CommunityActivityType::CAMPAIGN->is($type)) {
            $participants = fake()->numberBetween(0, 65535);
            $organizer = fake()->word();
            $location = fake()->words(asText: true);
        }

        return [
            'type' => $type,
            'name' => fake()->sentence(),
            'date' => fake()->date(),
            'outside_working_hours' => fake()->boolean(),

            'location' => $location ?? null,
            'organizer' => $organizer ?? null,
            'participants' => $participants ?? null,

            'notes' => fake()->paragraphs(asText: true),

            'nurse_id' => User::factory()->nurse(),
        ];
    }
}
