<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Recommendation;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recommendation>
 */
class RecommendationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
        ];
    }

    public function configure(): static
    {
        $services = Service::pluck('id');
        $vulnerabilities = Vulnerability::pluck('id');

        return $this->afterCreating(function (Recommendation $recommendation) use ($services, $vulnerabilities) {
            $recommendation->vulnerabilities()->sync($vulnerabilities->random(rand(1, 3)));
            $recommendation->services()->sync($services->random(rand(1, 9)));
        });
    }
}
