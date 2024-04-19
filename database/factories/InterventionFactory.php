<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\Family;
use App\Models\Intervention;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return $this->afterMaking(function (Intervention $intervention) {
            $count = $intervention->beneficiary
                ->catagraphy
                ->all_valid_vulnerabilities
                ->count();

            $intervention->setVulnerability(rand(0, $count));
        });
    }
}
