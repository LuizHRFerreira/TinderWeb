<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Option;
use App\Models\CharacteristicsOptionsUsers;
use App\Models\characteristics;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('roles')->insert([
            'name' => 'employee',
            'guard_name' => 'employee'
        ]);

        DB::table('apps')->insert([
            'name' => "tinder", 
        ]);        

        //$folderPath=storage_path('app/public/photos');
        //File::deleteDirectory($folderPath);

        User::factory(5)->create();

        characteristics::factory(5)->create();

        Option::factory(5)->create();

        CharacteristicsOptionsUsers::factory(5)->create();

        
    }
}
