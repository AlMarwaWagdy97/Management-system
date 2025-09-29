<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categories>
 */
class CategoriesFactory extends Factory
{

    public function definition()
    {
        $data = [];
        $langMenue = [];
        $items = Categories::query()->get();
        if((clone $items)->first()  == null){$item = Null;}
        else $item =  Categories::query()->get()->random();
        

        foreach(config('translatable.locales') as $locale){
            $title = fake()->name();
            $description = $this->faker->paragraph(3);
            $langMenue[$locale]['title'] = $title;
            $langMenue[$locale]['slug'] = slug($title);
            $langMenue[$locale]['description'] = $description;
        }

        $data += $langMenue + [
            'parent_id' => @$item->id,
            'level' => updateLevel(@$item),
            'status' =>  fake()->numberBetween($min = 0, $max = 1),
        ];
        return $data;
    }
}
