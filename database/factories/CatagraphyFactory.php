<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\User;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catagraphy>
 */
class CatagraphyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $vulnerabilities = Vulnerability::allAsOptions();

        return [
            'evaluation_date' => fake()->date(),
            'nurse_id' => User::factory()->withProfile(),
            'beneficiary_id' => Beneficiary::factory(),

            'cat_age' => fake()->randomElement($vulnerabilities->get('AGE')->keys()),
            'cat_as' => fake()->randomElement($vulnerabilities->get('AS')->keys()),
            'cat_cr' => fake()->randomElements($vulnerabilities->get('CR')->keys(), rand(1, 3)),
            'cat_diz' => fake()->randomElement($vulnerabilities->get('DIZ')->keys()),
            'cat_edu' => fake()->randomElement($vulnerabilities->get('EDU')->keys()),
            'cat_fam' => fake()->randomElements($vulnerabilities->get('FAM')->keys(), rand(1, 3)),
            'cat_id' => fake()->randomElement($vulnerabilities->get('ID')->keys()),
            'cat_inc' => fake()->randomElement($vulnerabilities->get('INC')->keys()),
            'cat_liv' => fake()->randomElements($vulnerabilities->get('LIV')->keys(), rand(1, 3)),
            'cat_mf' => fake()->randomElement($vulnerabilities->get('MF')->keys()),
            'cat_ns' => fake()->randomElements($vulnerabilities->get('NS')->keys(), rand(1, 3)),
            'cat_pov' => fake()->randomElement($vulnerabilities->get('POV')->keys()),
            'cat_preg' => fake()->randomElement($vulnerabilities->get('PREG')->keys()),
            'cat_rep' => fake()->randomElement($vulnerabilities->get('REP')->keys()),
            'cat_ss' => fake()->randomElements($vulnerabilities->get('SS')->keys(), rand(1, 3)),
            'cat_ssa' => fake()->randomElements($vulnerabilities->get('SSA')->keys(), rand(1, 3)),
            'cat_vif' => fake()->randomElements($vulnerabilities->get('VIF')->keys(), rand(1, 3)),
        ];
    }

    public function withNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => fake()->paragraphs(asText: true),
        ]);
    }
}
