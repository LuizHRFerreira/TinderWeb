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
use Spatie\Permission\Models\Permission;


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

        User::factory(50)->create();

        characteristics::factory(5)->create();

        Option::factory(10)->create();

        CharacteristicsOptionsUsers::factory(50)->create();

        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);

        $user = User::find(1);
        $user->assignRole('admin');
        $user->givePermissionTo('edit posts');

        
        
    }
}
