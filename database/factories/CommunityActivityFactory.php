<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CommunityActivity\Administrative;
use App\Enums\CommunityActivity\Campaign;
use App\Enums\CommunityActivity\Type;
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
        $type = fake()->randomElement(Type::cases());

        if (Type::CAMPAIGN->is($type)) {
            $participants = fake()->numberBetween(0, 65535);
            $roma_participants = fake()->boolean() ? fake()->numberBetween(0, 65535) : null;
            $organizer = fake()->word();
            $location = fake()->words(asText: true);
        }

        return [
            'type' => $type,
            'subtype' => match ($type) {
                Type::ADMINISTRATIVE => fake()->randomElement(Administrative::cases()),
                Type::CAMPAIGN => fake()->randomElement(Campaign::cases()),
            },
            'name' => fake()->sentence(),
            'date' => fake()->date(),
            'outside_working_hours' => fake()->boolean(),

            'location' => $location ?? null,
            'organizer' => $organizer ?? null,
            'participants' => $participants ?? null,
            'roma_participants' => $roma_participants ?? null,

            'notes' => fake()->paragraphs(asText: true),

            'nurse_id' => User::factory()->nurse(),
        ];
    }
}
