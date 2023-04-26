<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\User;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catagraphy>
 */
class CatagraphyFactory extends Factory
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
            'evaluation_date' => fake()->date(),
            'nurse_id' => User::factory()->withProfile(),
            'beneficiary_id' => Beneficiary::factory(),

            'cat_age' => fake()->randomElement($this->vulnerabilities->get('AGE')->keys()),
            'cat_as' => fake()->randomElement($this->vulnerabilities->get('AS')->keys()),
            'cat_cr' => fake()->randomElements($this->vulnerabilities->get('CR')->keys(), rand(1, 3)),
            'cat_edu' => fake()->randomElement($this->vulnerabilities->get('EDU')->keys()),
            'cat_fam' => fake()->randomElements($this->vulnerabilities->get('FAM')->keys(), rand(1, 3)),
            'cat_id' => fake()->randomElement($this->vulnerabilities->get('ID')->keys()),
            'cat_inc' => fake()->randomElement($this->vulnerabilities->get('INC')->keys()),
            'cat_liv' => fake()->randomElements($this->vulnerabilities->get('LIV')->keys(), rand(1, 3)),
            'cat_mf' => fake()->randomElement($this->vulnerabilities->get('MF')->keys()),
            'cat_ns' => fake()->randomElements($this->vulnerabilities->get('NS')->keys(), rand(1, 3)),
            'cat_pov' => fake()->randomElement($this->vulnerabilities->get('POV')->keys()),
            'cat_ss' => fake()->randomElements($this->vulnerabilities->get('SS')->keys(), rand(1, 3)),
            'cat_ssa' => fake()->randomElements($this->vulnerabilities->get('SSA')->keys(), rand(1, 3)),
            'cat_vif' => fake()->randomElements($this->vulnerabilities->get('VIF')->keys(), rand(1, 3)),
        ];
    }

    public function disability(): static
    {
        if (! fake()->boolean()) {
            return $this;
        }

        return $this->state(fn () => [
            'cat_diz' => fake()->randomElement($this->vulnerabilities->get('DIZ')->keys()),
            'cat_diz_tip' => fake()->randomElement($this->vulnerabilities->get('DIZ_TIP')->keys()),
            'cat_diz_gr' => fake()->randomElement($this->vulnerabilities->get('DIZ_GR')->keys()),
        ]);
    }

    public function reproductiveHealth(): static
    {
        if (! fake()->boolean()) {
            return $this;
        }

        return $this->state(fn () => [
            'cat_preg' => fake()->randomElement($this->vulnerabilities->get('PREG')->keys()),
            'cat_rep' => fake()->randomElement($this->vulnerabilities->get('REP')->keys()),
        ]);
    }

    public function withNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => fake()->paragraphs(asText: true),
        ]);
    }
}
