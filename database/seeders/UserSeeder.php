<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $super = User::create([
            'name' => 'Super Admin',
            'email' => 'super@super.com',
            'password' => bcrypt('123')
        ]);

        $super->assignRole('super-admin');

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123')
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User biasa',
            'email' => 'user@user.com',
            'password' => bcrypt('123')
        ]);

        $user->assignRole('user');

    }
}
