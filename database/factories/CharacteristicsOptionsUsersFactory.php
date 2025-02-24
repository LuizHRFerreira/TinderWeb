<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CharacteristicsOptionsUsers>
 */
class CharacteristicsOptionsUsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Escolhe um numero aleatorio entre 1 e 5 e armazena em uma variavel chamada numOptions
        $numOptions = $this->faker->unique()->numberBetween(1, 50);
        // Verifica se o numero gerado existe como uma option e armazena em um array chamado iAmOptions
        $iAmOptions = \App\Models\Option::inRandomOrder()->limit($numOptions)->pluck('id')->map(fn($id) => (string)$id)->toArray();

        // Escolhe um numero aleatorio entre 1 e 5 e armazena em uma variavel chamada numOptions
        $numOptions = $this->faker->numberBetween(1, 3);
        // Verifica se o numero gerado existecomo uma option e armazena em um array chamado iSeekOptions
        $iSeekOptions = \App\Models\Option::inRandomOrder()->limit($numOptions)->pluck('id')->map(fn($id) => (string)$id)->toArray();


        //Armazena os dados no banco
        return [
            'user_id'=> $this->faker->unique()->NumberBetween(1, 50),
            'i_am'=> json_encode($iAmOptions),
            'i_seek'=> json_encode($iSeekOptions),
        ];
    }
}
