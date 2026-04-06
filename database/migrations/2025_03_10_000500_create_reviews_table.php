<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('j2_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('anuncio_id')->constrained('j2_anuncios')->onDelete('cascade');
            $table->integer('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamps();
            $table->unique(['reviewer_id', 'anuncio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('j2_reviews');
    }
};
