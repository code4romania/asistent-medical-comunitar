<?php

declare(strict_types=1);

namespace Database\Factories\Intervention;

use App\Enums\Intervention\Status;
use App\Models\Intervention\CaseManagement;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

class IndividualServiceFactory extends Factory
{
    private function randomService(): int
    {
        return Cache::driver('array')->rememberForever(
            'all_services',
            fn () => Service::pluck('id')
        )->random();
    }

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
            'date' => fake()->date(),
            'integrated' => fake()->boolean(),
            'outside_working_hours' => fake()->boolean(15),
            'status' => fake()->randomElement(Status::values()),
            'notes' => fake()->text(),

            'service_id' => $this->randomService(),
            'vulnerability_id' => $this->randomVulnerability(),
        ];
    }

    public function belongsToCase(): static
    {
        return $this->state(fn () => [
            'beneficiary_id' => null,
            // 'case_id' => CaseManagement::factory(),
        ]);
    }
}
