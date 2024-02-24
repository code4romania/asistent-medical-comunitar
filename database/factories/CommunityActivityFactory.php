<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CommunityActivityType;
use App\Models\County;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

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

        switch ($type) {
            case CommunityActivityType::CAMPAIGN:
                $participants = fake()->numberBetween(0, 65535);

            case CommunityActivityType::ENVIRONMENT:
                $organizer = fake()->word();
                $location = fake()->words(asText: true);

            case CommunityActivityType::ADMINISTRATIVE:
                // noop
                break;
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

            'county_id' => Lottery::odds(4, 5)
                ->winner(fn () => County::inRandomOrder()->first()->id)
                ->loser(fn () => null)
                ->choose(),
        ];
    }
}
