<?php

namespace Database\Factories;

use App\Models\PortfolioTags;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PortfolioTagsFactory extends Factory
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
            $langTrans[$local]['slug'] = slug($title);
        }

        $data += $langTrans +[
            // 'image' => $this->faker->imageUrl(20,20),
            'sort' => rand(0, 100),
            'Feature' => $this->faker->randomElement(['1', '2']),
            'status' => $this->faker->randomElement(['1', '2']),
        ];
        return $data;
    }
}
