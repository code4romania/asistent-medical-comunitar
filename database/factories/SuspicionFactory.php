<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suspicion>
 */
class SuspicionFactory extends Factory
{
    protected ?Collection $vulnerabilities = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->vulnerabilities = Vulnerability::allAsOptions();

        return [
            'name' => fake()->sentence(),
            'category' => fake()->randomElement($this->vulnerabilities->get('SUS_CS')->keys()),
            'notes' => Lottery::odds(5, 6)
                ->winner(fn () => fake()->text(75))
                ->loser(fn () => null)
                ->choose(),
        ];
    }

    public function configure(): static
    {
        return $this->state(fn (array $attributes) => [
            'elements' => match ($attributes['category']) {
                'VSP_01' => fake()->randomElements(
                    $this->vulnerabilities->get('SUS_BR_ES')->keys(),
                    rand(1, 3)
                ),
                default => null,
            },
        ]);
    }
}
