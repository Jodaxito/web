<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('j2_anuncios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('categoria_id')->nullable()->constrained('j2_categorias')->nullOnDelete();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('tipo_operacion', 50);
            $table->decimal('precio', 10, 2)->nullable();
            $table->string('estado', 50)->default('DISPONIBLE');
            $table->string('ubicacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('j2_anuncios');
    }
};
