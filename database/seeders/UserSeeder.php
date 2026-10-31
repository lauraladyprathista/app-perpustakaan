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
        User::updateOrCreate(
            ['email' => 'admin@pens.ac.id'],
            ['name' => 'Bagus Wijaya', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'petugas1@pens.ac.id'],
            ['name' => 'Fina Rahmawati', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'petugas']
        );

        User::updateOrCreate(
            ['email' => 'petugas2@pens.ac.id'],
            ['name' => 'Hafiz Fauzi', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'petugas']
        );
    }
}