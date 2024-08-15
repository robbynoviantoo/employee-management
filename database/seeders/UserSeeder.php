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
        $users = [
            [
                'name' => 'Admin Erik',
                'email' => 'erik@admin.com',
                'password' => 'erik123!',
            ],
            [
                'name' => 'Admin Erma',
                'email' => 'erma@admin.com',
                'password' => 'erma123#',
            ],
            [
                'name' => 'Admin Robby',
                'email' => 'robby@admin.com',
                'password' => 'robby123',
            ],
            [
                'name' => 'Putri Pungkasari',
                'email' => 'putri@admin.com',
                'password' => 'putri123$',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // Kondisi pencarian
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                ]
            );
        }
    }
}