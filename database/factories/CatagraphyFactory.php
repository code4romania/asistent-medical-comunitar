<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Catagraphy\AgeCategory;
use App\Enums\Catagraphy\Disability;
use App\Enums\Catagraphy\DomesticViolence;
use App\Enums\Catagraphy\Education;
use App\Enums\Catagraphy\Family;
use App\Enums\Catagraphy\FamilyDoctor;
use App\Enums\Catagraphy\Habitation;
use App\Enums\Catagraphy\IDType;
use App\Enums\Catagraphy\Income;
use App\Enums\Catagraphy\Poverty;
use App\Enums\Catagraphy\SocialHealthInsurance;
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
