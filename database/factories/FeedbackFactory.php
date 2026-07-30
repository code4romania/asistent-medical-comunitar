<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackSubcategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = City::query()->inRandomOrder()->first();
        $category = FeedbackCategory::query()->inRandomOrder()->first();

        return [
            'category_id' => $category->id,
            'subcategory_id' => $category->subcategories()->inRandomOrder()->first()?->id,
            'description' => fake()->paragraph(),
            'county_id' => $city->county_id,
            'city_id' => $city->id,
            'user_id' => User::factory()->nurse(),
        ];
    }

    public function withSubcategory(): static
    {
        return $this->state(function (array $attributes): array {
            $subcategory = FeedbackSubcategory::query()
                ->inRandomOrder()
                ->first();

            return [
                'category_id' => $subcategory->category_id,
                'subcategory_id' => $subcategory->id,
            ];
        });
    }
}
