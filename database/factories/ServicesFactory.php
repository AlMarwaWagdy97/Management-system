<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ServicesFactory extends Factory
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
            $content = $this->faker->paragraph(3);

            $langTrans[$local]['title'] = $title;
            $langTrans[$local]['slug'] = slug($title);
            $langTrans[$local]['description'] = $description;
            $langTrans[$local]['content'] = $content;
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
