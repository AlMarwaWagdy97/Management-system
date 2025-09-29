<?php

namespace Database\Factories;

use App\Models\Portfolios;
use App\Models\PortfolioTags;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PortfoliosFactory extends Factory
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
            $description = $this->faker->paragraph(3);

            $langTrans[$local]['title'] = $title;
            $langTrans[$local]['slug'] = slug($title);
            $langTrans[$local]['description'] = $description;
        }
        $data += $langTrans +[
            // 'image' => $this->faker->imageUrl(20,20),
            'tag_id' => PortfolioTags::query()->get()->random()->id,
            'sort' => rand(0, 100),
            'feature' => $this->faker->randomElement(['1', '2']),
            'status' => $this->faker->randomElement(['1', '2']),
        ];
        return $data;

    }
}
