<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Rafael Fabiani',
            'email' => 'rafafabiani1909@gmail.com',
            'password' => Hash::make('asdf1234'),
        ]);
        User::create([
            'name' => 'Rafael Osinaga',
            'email' => 'rafaOsinaga@gmail.com',
            'password' => Hash::make('asdf1234'),
        ]);
        User::create([
            'name' => 'Jesus Iriarte',
            'email' => 'jes@gmail.com',
            'password' => Hash::make('asdf1234'),
        ]);
        User::create([
            'name' => 'Ale Papaya',
            'email' => 'papaya@gmail.com',
            'password' => Hash::make('asdf1234'),
        ]);
    }
}
