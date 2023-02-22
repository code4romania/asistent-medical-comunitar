<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Status;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Family;
use App\Models\Household;
use App\Models\Intervention;
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
        $family = Family::factory()->forHousehold()->create();

        return [
            'amc_id' => User::factory()->withProfile(),
            'household_id' => Household::factory(),
            'family_id' => Family::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'prior_name' => fake()->boolean(25) ? fake()->lastName() : null,
            'type' => fake()->randomElement(Type::values()),
            'status' => fake()->randomElement(Status::values()),
            'integrated' => fake()->boolean(),
            'gender' => fake()->randomElement(Gender::values()),
            'date_of_birth' => fake()->date(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Beneficiary $beneficiary) {
            if (! $beneficiary->isOcasional()) {
                return;
            }

            Intervention::factory()
                ->for($beneficiary)
                ->count(fake()->randomDigitNotNull())
                ->create();
        });
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

            return[
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
