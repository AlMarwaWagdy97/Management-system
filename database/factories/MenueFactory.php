<?php

namespace Database\Factories;

use App\Enums\MenuPositionEnum;
use App\Enums\MunesEnum;
use App\Models\Menue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MenueFactory extends Factory
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
        $menus = Menue::query()->get();
        if ((clone $menus)->first()  == null) {
            $menu = Null;
        } elseif ($menus->where('parent_id', '!=', NUll)->count() > 5) {
            $menu =  $menus->where('parent_id', '!=', Null)->random();
        } else $menu =  Menue::query()->get()->random();


        foreach (config('translatable.locales') as $locale) {
            $title = fake()->name();
            $langMenue[$locale]['title'] = $title;
            $langMenue[$locale]['slug'] = slug($title);
        }
        $positions = MenuPositionEnum::values();
        $data += $langMenue + [
            'parent_id'     => @$menu->id,
            'level'         => updateLevel(@$menu),
            'url'           =>  "/menues/" . slug($title),
            'type'          => MunesEnum::values()[array_rand(MunesEnum::values())],
            'status'        =>  fake()->numberBetween($min = 0, $max = 1),
            'position'      => array_rand(array_flip($positions)),
        ];
        return $data;
    }
}
