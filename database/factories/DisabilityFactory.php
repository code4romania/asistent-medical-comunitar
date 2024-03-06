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
class DisabilityFactory extends Factory
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
            'type' => fake()->randomElement($this->vulnerabilities->get('DIZ_TIP')->keys()),
            'degree' => fake()->randomElement($this->vulnerabilities->get('DIZ_GR')->keys()),
            'has_certificate' => fake()->boolean(),
            'receives_pension' => fake()->boolean(),
            'start_year' => fake()->year(),
            // 'diagnostic_id' => fake()->randomElement(),
            'notes' => fake()->text(75),
        ];
    }
}
