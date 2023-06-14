<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\Family;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

/**
 * @extends Factory<Family>
 */
class InterventionFactory extends Factory
{
    public function definition()
    {
        return [
            'integrated' => fake()->boolean(),
            'notes' => fake()->text(),
            'beneficiary_id' => Beneficiary::factory(),
            'vulnerability_id' => null,
            'closed_at' => fake()->boolean() ? fake()->dateTimeBetween('-2 months', '2 months') : null,
        ];
    }

    public function withVulnerability(): static
    {
        return $this->state(fn (array $attributes) => [
            'vulnerability_id' => $this->randomVulnerability(),
        ]);
    }

    private function randomVulnerability(): string
    {
        return Cache::driver('array')->rememberForever(
            'all_vulnerabilities',
            fn () => Vulnerability::pluck('id')
        )->random();
    }
}
