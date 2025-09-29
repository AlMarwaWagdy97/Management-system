<?php

namespace Database\Factories;

use App\Models\GiftCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftOccasioins>
 */
class GiftOccasioinsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [];
        $langTrans = [];
        foreach(config('translatable.locales') as $local){
            $title = $this->faker->name();
            $langTrans[$local]['title'] = $title;
        }

        $data += $langTrans +[
            'sort' => rand(0, 100),
            'status' => $this->faker->randomElement(['1', '2']),
        ];
        return $data;
    }
}
