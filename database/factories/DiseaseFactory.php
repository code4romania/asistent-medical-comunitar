<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends Factory<City>
 */
class DiseaseFactory extends Factory
{
    protected ?Collection $vulnerabilities = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->vulnerabilities = Vulnerability::allAsOptions();

        return [
            'type' => fake()->randomElement($this->vulnerabilities->get('SS')->except('VSG_99')->keys()),
            'category' => fake()->randomElement($this->vulnerabilities->get('SS_B')->keys()),
            'start_year' => fake()->year(),
            // 'diagnostic_id' => fake()->randomElement(),
            'notes' => fake()->text(75),
        ];
    }
}
