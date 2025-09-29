<?php

namespace Database\Factories;

use App\Models\GiftCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftCategories>
 */
class GiftCategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [];
        $langMenue = [];
        $items = GiftCategories::query()->get();
        if((clone $items)->first()  == null){$item = Null;}
        else $item =  GiftCategories::query()->get()->random();
        
        foreach(config('translatable.locales') as $locale){
            $title = fake()->name();
            $langMenue[$locale]['title'] = $title;
        }

        $data = $langMenue + [
            'parent_id' => @$item->id,
            'level' => updateLevel(@$item),
            'status' =>  fake()->numberBetween($min = 0, $max = 1),
        ];
        return $data;      
    }
}
