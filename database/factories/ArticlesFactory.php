<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Articles>
 */
class ArticlesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {  
        $data = [];
        $langTrans = [];
        foreach(config('translatable.locales') as $local){

            $title = $this->faker->name();
            $content = $this->faker->paragraph(3);
            $description = $this->faker->paragraph(3);
            $meta_title = $this->faker->name(3);
            $meta_description = $this->faker->paragraph(3);
            $meta_key = $this->faker->paragraph(3);

            $langTrans[$local]['title'] = $title;
            $langTrans[$local]['slug'] = slug($title);
            $langTrans[$local]['content'] = $content;
            $langTrans[$local]['description'] = $description;
            $langTrans[$local]['meta_title'] = $meta_title;
            $langTrans[$local]['meta_description'] = $meta_description;
            $langTrans[$local]['meta_key'] = $meta_key;
        }

        $data += $langTrans +[
            'image' => $this->faker->imageUrl(50,50),
            'status' => $this->faker->randomElement($array = array ('1','2')),
            'sort' => $this->faker->randomElement($array = array ('1','2')),
            'news_ticker' => $this->faker->randomElement($array = array ('1','2')),
        ];
        return $data;
    }
}
