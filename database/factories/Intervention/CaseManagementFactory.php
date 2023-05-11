<?php

declare(strict_types=1);

namespace Database\Factories\Intervention;

use App\Enums\Intervention\CaseInitiator;
use App\Models\Beneficiary;
use App\Models\Intervention\CaseManagement;
use App\Models\Intervention\IndividualService;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

class CaseManagementFactory extends Factory
{
    private function randomVulnerability(): string
    {
        return Cache::driver('array')->rememberForever(
            'all_vulnerabilities',
            fn () => Vulnerability::pluck('id')
        )->random();
    }

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'integrated' => fake()->boolean(),
            'initiator' => fake()->randomElement(CaseInitiator::values()),
            'imported' => fake()->boolean(10),
            'notes' => fake()->text(),
            'closed_at' => fake()->boolean() ? fake()->dateTime() : null,

            'beneficiary_id' => Beneficiary::factory(),
            'vulnerability_id' => $this->randomVulnerability(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (CaseManagement $case) {
            IndividualService::factory()
                ->for($case, 'case')
                ->count(fake()->randomDigitNotNull())
                ->create();
        });
    }
}
