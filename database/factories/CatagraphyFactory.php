<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Vulnerability\AgeCategory;
use App\Enums\Vulnerability\Disability;
use App\Enums\Vulnerability\DomesticViolence;
use App\Enums\Vulnerability\Education;
use App\Enums\Vulnerability\Family;
use App\Enums\Vulnerability\FamilyDoctor;
use App\Enums\Vulnerability\Habitation;
use App\Enums\Vulnerability\IDType;
use App\Enums\Vulnerability\Income;
use App\Enums\Vulnerability\Poverty;
use App\Enums\Vulnerability\RiskBehavior;
use App\Enums\Vulnerability\SocialHealthInsurance;
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
            'age_category' => fake()->randomElement(AgeCategory::values()),
            'disability' => fake()->randomElement(Disability::values()),
            'domestic_violence' => fake()->randomElements(DomesticViolence::values(), 2),
            'education' => fake()->randomElement(Education::values()),
            'evaluation_date' => fake()->date(),
            'family_doctor' => fake()->randomElement(FamilyDoctor::values()),
            'family' => fake()->randomElements(Family::values(), 2),
            'habitation' => fake()->randomElements(Habitation::values(), 1),
            'id_type' => fake()->randomElement(IDType::values()),
            'income' => fake()->randomElement(Income::values()),
            'poverty' => fake()->randomElement(Poverty::values()),
            'risk_behavior' => fake()->randomElement(RiskBehavior::values()),
            'social_health_insurance' => fake()->randomElement(SocialHealthInsurance::values()),

            'nurse_id' => User::factory()->withProfile(),
            'beneficiary_id' => Beneficiary::factory(),
        ];
    }

    public function withNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => fake()->paragraphs(asText: true),
        ]);
    }
}
