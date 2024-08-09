<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Erik',
            'email' => 'erik@admin.com',
            'password' => Hash::make('erik123!'), // Ganti dengan password yang aman
        ]);
        User::create([
            'name' => 'Admin Erma',
            'email' => 'erma@admin.com',
            'password' => Hash::make('erma123#'), // Ganti dengan password yang aman
        ]);
        User::create([
            'name' => 'Admin Robby',
            'email' => 'robby@admin.com',
            'password' => Hash::make('robby123'), // Ganti dengan password yang aman
        ]);
    }
}