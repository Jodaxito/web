<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('tipo_operacion', ['COMPRA', 'VENTA', 'INTERCAMBIO', 'DONACION']);
            $table->decimal('precio', 10, 2)->nullable();
            $table->enum('estado', ['DISPONIBLE', 'RESERVADO', 'CERRADO'])->default('DISPONIBLE');
            $table->string('ubicacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anuncios');
    }
};
