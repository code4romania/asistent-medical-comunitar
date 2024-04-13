<?php

declare(strict_types=1);

namespace Database\Factories\Intervention;

use App\Enums\Intervention\CaseInitiator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

class InterventionableCaseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'initiator' => fake()->randomElement(CaseInitiator::values()),
            'is_imported' => fake()->boolean(10),
            'recommendations' => Lottery::odds(3, 4)
                ->winner(fn () => fake()->paragraphs(3, true))
                ->loser(fn () => null)
                ->choose(),
        ];
    }
}
