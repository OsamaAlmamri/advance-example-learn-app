<?php

namespace Database\Factories;

use App\Models\Chanal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chanal>
 */
class ChanalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */



    protected $model = Chanal::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
