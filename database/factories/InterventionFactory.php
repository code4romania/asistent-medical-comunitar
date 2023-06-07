<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\Family;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableCase;
use App\Models\Intervention\InterventionableIndividualService;
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
            'beneficiary_id' => Beneficiary::factory(),
            'vulnerability_id' => $this->randomVulnerability(),
        ];
    }

    private function randomVulnerability(): string
    {
        return Cache::driver('array')->rememberForever(
            'all_vulnerabilities',
            fn () => Vulnerability::pluck('id')
        )->random();
    }

    public function case(): static
    {
        return $this->for(InterventionableCase::factory(), 'interventionable')
            ->afterCreating(function (Intervention $intervention) {
                Intervention::factory()
                    ->individualService()
                    ->recycle($intervention->beneficiary)
                    ->for($intervention->interventionable, 'case')
                    ->count(fake()->randomDigitNotNull())
                    ->create();
            });
    }

    public function individualService(): static
    {
        return $this->for(InterventionableIndividualService::factory(), 'interventionable');
    }
}
