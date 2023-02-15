<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;

    public function definition()
    {

        return [
            'name' => fake()->name(),
            'user_id' => User::factory(),
            "contracted_at"=>fake()->dateTime(),
            'active' => random_int(0, 1)
        ];
    }
}
