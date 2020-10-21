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
