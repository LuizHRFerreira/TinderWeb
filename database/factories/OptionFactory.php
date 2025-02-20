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
        static $characteristicId = 1;
        static $optionCount = 1;

        $data = [
            'characteristics_id' => $characteristicId,
            'name' => $this->faker->unique()->word,
        ];

        $optionCount++;

        if ($optionCount > 2) {  // Reset after two options
            $characteristicId++;
            $optionCount = 1;
        }

        if ($characteristicId > 5) { //stop creating after characteristc 5
            $characteristicId = 1;
        }


        return $data;
    }
}
