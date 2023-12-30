<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('VERY_SECRET_PASSWORD'),
            'role' => User::ROLE_USER
        ]);
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@hotmail.com',
            'password' => bcrypt('VERY_SECRET_PASSWORD'),
            'role' => User::ROLE_ADMIN
        ]);
        DB::table('users')->insert([
            'name' => 'Super',
            'email' => 'superadmin@hotmail.com',
            'password' => bcrypt('VERY_SECRET_PASSWORD'),
            'role' => User::ROLE_SUPERADMIN
        ]);
    }
}
