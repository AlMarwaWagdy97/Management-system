<?php

namespace Database\Factories;

use App\Models\GiftCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftCards>
 */
class GiftCardsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' =>  GiftCategories::query()->get()->random(),
            // 'image' => $this->faker->imageUrl(20,20),
            'sort' => rand(0, 100),
            'status' => $this->faker->randomElement(['1', '2']),
        ];
    }
}
