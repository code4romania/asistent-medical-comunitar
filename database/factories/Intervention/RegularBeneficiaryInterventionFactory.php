<?php

declare(strict_types=1);

namespace Database\Factories\Intervention;

use App\Models\Beneficiary;
use App\Models\Intervention\RegularBeneficiaryIntervention;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervention>
 */
class RegularBeneficiaryInterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reason' => fake()->sentence(),
            'date' => fake()->date(),
            'beneficiary_id' => Beneficiary::factory(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (RegularBeneficiaryIntervention $intervention) {
            $intervention->service()->attach(
                Service::query()
                    ->inRandomOrder()
                    ->limit(2)
                    ->get()
            );
        });
    }
}
