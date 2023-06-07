<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Status;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use App\Models\City;
use App\Models\Family;
use App\Models\Intervention;
use App\Models\Intervention\OcasionalIntervention;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = fake()->randomElement(Status::values());

        return [
            'nurse_id' => User::factory(),
            'family_id' => Family::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'prior_name' => fake()->boolean(25) ? fake()->lastName() : null,
            'type' => fake()->randomElement(Type::values()),
            'integrated' => fake()->boolean(),
            'gender' => fake()->randomElement(Gender::values()),
            'date_of_birth' => fake()->date(),

            'status' => $status,
            'reason_removed' => Status::REMOVED->is($status) ? fake()->sentence() : null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Beneficiary $beneficiary) {
            if ($beneficiary->isOcasional()) {
                OcasionalIntervention::factory()
                    ->for($beneficiary)
                    ->count(fake()->randomDigitNotNull())
                    ->create();
            }

            if ($beneficiary->isRegular()) {
                Catagraphy::factory()
                    ->recycle($beneficiary->nurse)
                    ->for($beneficiary)
                    ->disability()
                    ->reproductiveHealth()
                    ->withNotes()
                    ->create();

                Intervention::factory()
                    ->case()
                    ->recycle($beneficiary)
                    ->count(fake()->randomDigitNotNull())
                    ->create();

                Intervention::factory()
                    ->individualService()
                    ->recycle($beneficiary)
                    ->count(fake()->randomDigitNotNull())
                    ->create();

                Appointment::factory()
                    ->recycle($beneficiary->nurse)
                    ->for($beneficiary)
                    ->count(fake()->randomDigitNotNull())
                    ->has(
                        Intervention::factory()
                            ->individualService()
                            ->recycle($beneficiary)
                            ->count(fake()->randomDigitNotNull()),
                        'interventions'
                    )
                    ->create();
            }
        });
    }

    public function withCNP(): static
    {
        return $this->state(fn (array $attributes) => [
            'cnp' => fake()->cnp(
                dateOfBirth: $attributes['date_of_birth'],
            ),
        ]);
    }

    public function withID(): static
    {
        return $this->state(fn (array $attributes) => [
            'id_type' => fake()->randomElement(IDType::values()),
            'id_serial' => fake()->lexify('??'),
            'id_number' => fake()->numerify('######'),
        ]);
    }

    public function withAddress(): static
    {
        return $this->state(function (array $attributes) {
            $city = City::query()->inRandomOrder()->first();

            return [
                'address' => fake()->address(),
                'county_id' => $city->county_id,
                'city_id' => $city->id,
            ];
        });
    }

    public function withNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => fake()->paragraphs(asText: true),
        ]);
    }
}
