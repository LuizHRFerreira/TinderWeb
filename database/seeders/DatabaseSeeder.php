<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Option;
use App\Models\CharacteristicsOptionsUsers;
use App\Models\characteristics;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('apps')->insert([
            'name' => "tinder", 
        ]); a       

        User::factory(5)->create();

        characteristics::factory(5)->create();

        Option::factory(5)->create();

        CharacteristicsOptionsUsers::factory(5)->create();

    }
}
