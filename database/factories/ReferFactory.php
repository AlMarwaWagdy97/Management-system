<?php

namespace Database\Factories;

use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Models\AccountTypes;
use App\Models\Refer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $referID = LoginTypes::where('type', 'refer')->get('id')->first()->id;
        $account = Accounts::create([
            'user_name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make($this->faker->password()),
            'status' => true,
        ]);

        AccountTypes::create([
            'account_id' =>  $account->id,
            'type_id' => $referID,
        ]);

        $name = $this->faker->name();
        return [
            'account_id'            =>  $account->id,
            'name'                  =>  $name,
            'slug'                  =>  $name,
            'employee_name'         =>  $this->faker->name(),
            'employee_department'   =>  $this->faker->name(),
        ];
    }
}
