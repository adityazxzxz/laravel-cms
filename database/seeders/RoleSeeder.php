<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'read role']);

        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'read user']);

        

        $superadmin = Role::create([
            'name' => 'super-admin',
            'guard_name' => 'web'
        ]);

        $superadmin->givePermissionTo(['name' => 'create role']);
        $superadmin->givePermissionTo(['name' => 'update role']);
        $superadmin->givePermissionTo(['name' => 'delete role']);
        $superadmin->givePermissionTo(['name' => 'read role']);

        $superadmin->givePermissionTo(['name' => 'create user']);
        $superadmin->givePermissionTo(['name' => 'update user']);
        $superadmin->givePermissionTo(['name' => 'delete user']);
        $superadmin->givePermissionTo(['name' => 'read user']);

        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $user = Role::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        $user->givePermissionTo(['name' => 'read user']);
        $user->givePermissionTo(['name' => 'create user']);
    }
}
