<?php

declare(strict_types=1);

namespace Database\Factories\Intervention;

use App\Enums\Intervention\Status;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

class InterventionableIndividualServiceFactory extends Factory
{
    private function randomService(): int
    {
        return Cache::driver('array')->rememberForever(
            'all_services',
            fn () => Service::pluck('id')
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
        ];
    }
}
