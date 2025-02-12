<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Option;
use App\Models\characteristics;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('apps')->insert([
            'name' => "tinder", 
        ]);        

        User::factory(5)->create();

        characteristics::factory(5)->create();

        Option::factory(5)->create();

        DB::table('characteristics_options_users')->insert([
            'users_id' => 1,
            'characteristics_id' => 1,
            'i_am' => 1,
            'i_seek' => 1,
        ]);
    }
}
