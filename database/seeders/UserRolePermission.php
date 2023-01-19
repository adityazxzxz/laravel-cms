<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        $super = User::create(array_merge([
            'email' => 'super@super.com',
            'name' => 'Super User',
        ], $default_value_user));

        $admin = User::create(array_merge([
            'email' => 'admin@admin.com',
            'name' => 'administrator',
        ], $default_value_user));

        $creator = User::create(array_merge([
            'email' => 'creator@creator.com',
            'name' => 'creator',
        ], $default_value_user));

        $publisher = User::create(array_merge([
            'email' => 'publisher@publisher.com',
            'name' => 'publisher',
        ], $default_value_user));

        $super_role = Role::create(['name' => 'super']);
        $admin_role = Role::create(['name' => 'admin']);
        $creator_role = Role::create(['name' => 'creator']);
        $publisher_role = Role::create(['name' => 'publisher']);

        Permission::create(['name' => 'read role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        $super->assignRole('super');
        $super->assignRole('admin');
        $admin->assignRole('admin');
        $creator->assignRole('creator');
        $publisher->assignRole('publisher');
    }
}
