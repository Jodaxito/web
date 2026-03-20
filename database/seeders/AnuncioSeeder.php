<?php

namespace Database\Seeders;

use App\Models\Anuncio;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnuncioSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::first();
        if (! $user) {
            $user = User::factory()->create();
        }

        $categorias = Categoria::all();

        for ($i = 1; $i <= 20; $i++) {
            Anuncio::create([
                'user_id' => $user->id,
                'categoria_id' => $categorias->random()->id,
                'titulo' => "Anuncio ejemplo $i",
                'descripcion' => "Descripción del anuncio ejemplo $i",
                'tipo_operacion' => collect(['VENTA','COMPRA','INTERCAMBIO','DONACION'])->random(),
                'precio' => rand(1,100) * 10,
                'estado' => 'DISPONIBLE',
                'ubicacion' => 'Campus',
            ]);
        }
    }
}
