<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\option;

class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'characteristics_id'=> $this->faker->NumberBetween(1, 5),
            'name'=> $this->faker->unique()->word,
        ];
    }
}
