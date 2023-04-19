<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Vulnerability;
use App\Models\Beneficiary;
use App\Models\User;
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
        return [
            'evaluation_date' => fake()->date(),
            'nurse_id' => User::factory()->withProfile(),
            'beneficiary_id' => Beneficiary::factory(),

            'cat_age' => fake()->randomElement(Vulnerability\CatAge::values()),
            'cat_as' => fake()->randomElement(Vulnerability\CatAs::values()),
            'cat_cr' => fake()->randomElements(Vulnerability\CatCr::values(), rand(1, 3)),
            'cat_diz' => fake()->randomElement(Vulnerability\CatDiz::values()),
            'cat_edu' => fake()->randomElement(Vulnerability\CatEdu::values()),
            'cat_fam' => fake()->randomElements(Vulnerability\CatFam::values(), rand(1, 3)),
            'cat_id' => fake()->randomElement(Vulnerability\CatId::values()),
            'cat_inc' => fake()->randomElement(Vulnerability\CatInc::values()),
            'cat_liv' => fake()->randomElements(Vulnerability\CatLiv::values(), rand(1, 3)),
            'cat_mf' => fake()->randomElement(Vulnerability\CatMf::values()),
            'cat_ns' => fake()->randomElements(Vulnerability\CatNs::values(), rand(1, 3)),
            'cat_pov' => fake()->randomElement(Vulnerability\CatPov::values()),
            'cat_preg' => fake()->randomElement(Vulnerability\CatPreg::values()),
            'cat_rep' => fake()->randomElement(Vulnerability\CatRep::values()),
            'cat_ss' => fake()->randomElements(Vulnerability\CatSs::values(), rand(1, 3)),
            'cat_ssa' => fake()->randomElements(Vulnerability\CatSsa::values(), rand(1, 3)),
            'cat_vif' => fake()->randomElements(Vulnerability\CatVif::values(), rand(1, 3)),
        ];
    }

    public function withNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => fake()->paragraphs(asText: true),
        ]);
    }
}
