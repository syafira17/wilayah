<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'petugas1',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'petugas'
        ]);
    }
} 