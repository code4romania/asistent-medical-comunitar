<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\ICD10AM\ICD10AMDiagnostic;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Lottery;

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
        $diagnostics = ICD10AMDiagnostic::pluck('id');

        return [
            'type' => fake()->randomElement($this->vulnerabilities->get('SS')->except('VSG_99')->keys()),
            'category' => fake()->randomElement($this->vulnerabilities->get('SS_B')->except('VSG_BR')->keys()),
            'start_year' => fake()->year(),
            'diagnostic_id' => Lottery::odds(5, 9)
                ->winner(fn () => $diagnostics->random())
                ->loser(fn () => null)
                ->choose(),
            'notes' => fake()->text(75),
        ];
    }

    public function rare(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'VSG_BR',
            'rare_disease' => Lottery::odds(1, 3)
                ->winner(fn () => Vulnerability::allAsOptions()->get('SS_SL')->keys()->random())
                ->loser(fn () => null)
                ->choose(),
        ]);
    }
}
