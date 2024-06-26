<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Membuat peran admin
        Role::create(['name' => 'admin']);

        // Membuat peran pelanggan
        Role::create(['name' => 'pelanggan']);
    }
}