<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name'     => fake()->firstName(),
            'last_name'      => fake()->lastName(),
            'email'          => fake()->unique()->safeEmail(),
            'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function withProfile(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone'                => fake()->phoneNumber(),
            'date_of_birth'        => fake()->date(),
            'gender'               => fake()->randomElement(Gender::values()),
            'cnp'                  => null,
            'accreditation_number' => null,
            'accreditation_date'   => fake()->date(),
        ]);
    }
}
