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
            'evaluation_date' => fake()->date(),
            'age_category' => fake()->randomElement(AgeCategory::values()),
            'disability' => fake()->randomElement(Disability::values()),
            'domestic_violence' => fake()->randomElements(DomesticViolence::values(), 2),
            'education' => fake()->randomElement(Education::values()),
            'family_doctor' => fake()->randomElement(FamilyDoctor::values()),
            'family' => fake()->randomElements(Family::values(), 2),
            'habitation' => fake()->randomElement(Habitation::values()),
            'id_type' => fake()->randomElement(IDType::values()),
            'income' => fake()->randomElement(Income::values()),
            'poverty' => fake()->randomElements(Poverty::values(), 2),
            'social_health_insurance' => fake()->randomElement(SocialHealthInsurance::values()),

            'amc_id' => User::factory()->withProfile(),
            'beneficiary_id' => Beneficiary::factory(),
        ];
    }
}
