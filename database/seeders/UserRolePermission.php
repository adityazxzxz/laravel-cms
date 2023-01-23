<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_value_user = [
            'email_verified_at' => now(),
            'password' => Hash::make('super'),
            'remember_token' => Str::random(10),
        ];

        $super = User::create(array_merge([
            'email' => 'super@super.com',
            'name' => 'Super User',
        ], $default_value_user));

        $admin = User::create([
            'email' => 'admin@admin.com',
            'name' => 'administrator',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ]);

        // $creator = User::create(array_merge([
        //     'email' => 'creator@creator.com',
        //     'name' => 'creator',
        // ], $default_value_user));

        // $publisher = User::create(array_merge([
        //     'email' => 'publisher@publisher.com',
        //     'name' => 'publisher',
        // ], $default_value_user));

        Role::create(['name' => 'super']);
        $role = Role::create(['name' => 'admin']);
        // $creator_role = Role::create(['name' => 'creator']);
        // $publisher_role = Role::create(['name' => 'publisher']);

        Permission::create(['name' => 'read role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'read permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'read user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        $super->assignRole('super');
        $admin->assignRole('admin');
        $role->syncPermissions(Permission::all());
        // $creator->assignRole('creator');
        // $publisher->assignRole('publisher');
    }
}
