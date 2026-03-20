<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\CategoriaSeeder;
use Database\Seeders\AnuncioSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario admin de prueba
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
            'verificado' => true
        ]);

        // Usuario de prueba regular
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'bio' => 'Un vendedor confiable en JODAXI',
            'telefono' => '3012345678',
            'verificado' => true
        ]);

        // Usuarios adicionales de prueba
        User::factory(3)->create();

        // populate categories and anuncios for development
        $this->call(CategoriaSeeder::class);
        $this->call(AnuncioSeeder::class);
    }
}
