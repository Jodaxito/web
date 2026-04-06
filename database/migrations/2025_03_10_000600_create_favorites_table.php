<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('j2_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('anuncio_id')->constrained('j2_anuncios')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_id', 'anuncio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('j2_favorites');
    }
};
