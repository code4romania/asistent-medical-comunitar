<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\User\Role;
use App\Models\CommunityActivity;
use App\Models\County;
use App\Models\Profile\Course;
use App\Models\Profile\Employer;
use App\Models\Profile\Study;
use App\Models\Vacation;
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
            'uuid' => Str::orderedUuid(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
            'password_set_at' => fake()->dateTime(),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::ADMIN,
        ]);
    }

    public function coordinator(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::COORDINATOR,
            'county_id' => County::query()->inRandomOrder()->first()->id,
        ]);
    }

    public function nurse(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::NURSE,
            'activity_county_id' => County::query()->inRandomOrder()->first()->id,
        ]);
    }

    public function invited(): static
    {
        return $this->state(fn (array $attributes) => [
            'password_set_at' => null,
        ]);
    }

    public function deactivated(): static
    {
        return $this->state(fn (array $attributes) => [
            'deactivated_at' => fake()->dateTime(),
        ]);
    }

    public function withProfile(): static
    {
        return $this
            ->nurse()
            ->state(fn (array $attributes) => [
                'phone' => fake()->phoneNumber(),
                'date_of_birth' => fake()->date(),
                'gender' => fake()->randomElement(Gender::values()),
                'cnp' => null,
                'accreditation_number' => null,
                'accreditation_date' => fake()->date(),
                'profile_completed_at' => now(),
                'has_participated_specialization' => fake()->boolean(),
                'has_graduated_specialization' => fake()->boolean(),
            ])
            ->has(Study::factory()->count(5))
            ->has(Course::factory()->count(10))
            ->has(Employer::factory()->past()->withGPAgreement())
            ->has(Employer::factory()->past()->withProject())
            ->has(Employer::factory()->current())
            ->has(CommunityActivity::factory()->count(10))
            ->has(Vacation::factory()->count(5));
    }
}
