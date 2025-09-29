<?php

namespace Database\Factories;

use App\Models\Menue;
use App\Enums\MunesEnum;
use App\Enums\ProjectTypesEnum;
use App\Models\CategoryProjects;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryProjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $data = [];
        $langMenue = [];
        $items = CategoryProjects::query()->get();
        if((clone $items)->first()  == null){$item = Null;}
        elseif($items->where('parent_id', NUll)->count() > 5){; $item =  $items->where('parent_id', '!=', Null)->random();}
        else $item =  CategoryProjects::query()->get()->random();
        

        foreach(config('translatable.locales') as $locale){
            $title = fake()->name();
            $description = $this->faker->paragraph(3);
            $langMenue[$locale]['title'] = $title;
            $langMenue[$locale]['slug'] = slug($title);
            $langMenue[$locale]['description'] = slug($description);
        }

        $data += $langMenue + [
            'parent_id' => @$item->id,
            'level' => updateLevel(@$item),
            'project_types'   => ProjectTypesEnum::values()[array_rand(ProjectTypesEnum::values())],
            'status' =>  fake()->numberBetween($min = 0, $max = 1),
        ];
        return $data;
    }
}
