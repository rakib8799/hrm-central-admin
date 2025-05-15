<?php

namespace Database\Seeders;

use App\Models\User;
use App\Constants\Constants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345'),
            'remember_token' => Str::random(10)
        ]);
        $user->assignRole(Constants::ROLE_SUPER_ADMIN);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
