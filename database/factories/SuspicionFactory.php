<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Suspicion\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suspicion>
 */
class SuspicionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'category' => fake()->randomElement(Category::values()),
            // 'elements' => fake()->randomElements(['element1', 'element2', 'element3'], 2),
            'notes' => Lottery::odds(5, 6)
                ->winner(fn () => fake()->text(75))
                ->loser(fn () => null)
                ->choose(),
        ];
    }
}
