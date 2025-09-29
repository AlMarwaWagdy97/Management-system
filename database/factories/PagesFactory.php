<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pages>
 */
class PagesFactory extends Factory
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
            $meta_title = $this->faker->name(3);
            $meta_description = $this->faker->paragraph(3);
            $meta_key = $this->faker->paragraph(3);


            $langTrans[$local]['title'] = $title;
            $langTrans[$local]['slug'] = slug($title);
            $langTrans[$local]['content'] = $content;
            $langTrans[$local]['meta_title'] = $meta_title;
            $langTrans[$local]['meta_description'] = $meta_description;
            $langTrans[$local]['meta_key'] = $meta_key;

         
        }

        $data += $langTrans +[
            // 'image' => $this->faker->imageUrl(20,20),
            'status' => $this->faker->randomElement($array = array ('1','2'))
        ];
        return $data;

    }
}
