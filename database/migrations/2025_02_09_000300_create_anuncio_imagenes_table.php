<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('j2_anuncio_imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anuncio_id')->constrained('j2_anuncios')->cascadeOnDelete();
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('j2_anuncio_imagenes');
    }
};
