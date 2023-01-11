<?php

namespace Database\Factories;

use App\Enums\StudyType;
use App\Models\ProfileStudy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfileStudy>
 */
class ProfileStudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faculties =  ['Colegiul de Moașe și Asistente','Facultatea de Medicina Iasi','USAMV Iasi','UMF'];
        $names = ['Moașe și Asistente',' Master in neurochirugie','Doctorant in psihologie'];
        return [
            'name' => fake()->randomElement($names),
            'type' => fake()->randomElement(StudyType::values()),
            'emitted_institution' => fake()->randomElement($faculties),
            'duration' => fake()->randomDigitNotZero(),
            'start_year' =>fake()->year(),
            'end_year' => fake()->year(),
        ];
    }
}
