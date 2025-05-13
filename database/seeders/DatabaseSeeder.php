<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 5 vendedores de ejemplo
        User::create([
            'name' => 'Ana Gómez',
            'email' => 'ana.gomez@example.com',
            'password' => bcrypt('password123'),
        ]);
        User::create([
            'name' => 'Carlos Ruiz',
            'email' => 'carlos.ruiz@example.com',
            'password' => bcrypt('password123'),
        ]);
        User::create([
            'name' => 'María López',
            'email' => 'maria.lopez@example.com',
            'password' => bcrypt('password123'),
        ]);
        User::create([
            'name' => 'Jorge Díaz',
            'email' => 'jorge.diaz@example.com',
            'password' => bcrypt('password123'),
        ]);
        User::create([
            'name' => 'Luisa Fernández',
            'email' => 'luisa.fernandez@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
