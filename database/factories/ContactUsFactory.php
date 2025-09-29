<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contactus>
 */
class ContactUsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'full_name' => $this->faker->name(),
            'title' => $this->faker->name(),
            'email' =>$this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'city' => $this->faker->word(),
            'type' => $this->faker->boolean(),
            'message' => $this->faker->paragraph(3),
            'status' => $this->faker->boolean(),
        ];
    }
}
