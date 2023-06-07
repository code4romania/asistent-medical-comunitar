<?php

declare(strict_types=1);

namespace Database\Factories\Intervention;

use App\Enums\Intervention\CaseInitiator;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterventionableCaseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'integrated' => fake()->boolean(),
            'initiator' => fake()->randomElement(CaseInitiator::values()),
            'is_imported' => fake()->boolean(10),
            'notes' => fake()->text(),
            'closed_at' => fake()->boolean() ? fake()->dateTime() : null,
        ];
    }
}
