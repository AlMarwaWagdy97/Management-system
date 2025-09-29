<?php

namespace Database\Factories;

use App\Enums\LocationTypeEnum;
use App\Enums\ProjectTypesEnum;
use App\Models\CategoryProjects;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CharityProjectFactory extends Factory
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
        $donation_type = ['{"type":"open"}',
                          '{"type":"fixed","data":"500"}',
                          '{"type":"share","data":[{"name":"sahm","value":"300"},{"name":"sdaka","value":"400"}]}'];
        foreach(config('translatable.locales') as $local){
            $title = $this->faker->name();
            $description = $this->faker->paragraph(3);
            $langTrans[$local]['title'] = $title;
            $langTrans[$local]['slug'] = slug($title);
            $langTrans[$local]['description'] = $description;
        }

        $data += $langTrans +[
            // 'image' => $this->faker->imageUrl(20,20),
            'number' => rand(999, 10000),
            'category_id' => CategoryProjects::query()->get()->random()->id, 
            'project_types'   => ProjectTypesEnum::values()[array_rand(ProjectTypesEnum::values())],
            'location_type'   => LocationTypeEnum::values()[array_rand(LocationTypeEnum::values())],
            'sort' => rand(0, 100),
            'featuer' => $this->faker->randomElement(['1', '2']),
            'status' => $this->faker->randomElement(['1', '2']),
            'finished' => $this->faker->randomElement(['1', '2']),
            'donation_type' => array_rand($donation_type),
        ];
        return $data;

    }
}
