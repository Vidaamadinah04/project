<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);

        $admin = User::create([
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => '2',
        ]);

        // Tetapkan peran admin kepada pengguna
        $admin->assignRole('admin');

        $pelanggan = User::create([
            'username' => ' User',
            'email' => 'pelanggan@gmail.com',
            'password' => bcrypt('password'),
            'role' => '1',
        ]);

        // Tetapkan peran pelanggan kepada pengguna
        $pelanggan->assignRole('pelanggan');
    }
}
