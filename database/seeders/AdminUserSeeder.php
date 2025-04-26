<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'adminka@gmail.com',
        ], [
            'name' => 'Admin',
            'email' => 'adminka@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => true, // Добавим поле, если нужно
        ]);
    }
}
