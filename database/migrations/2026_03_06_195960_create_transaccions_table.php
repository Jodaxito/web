<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('j2_transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('j2_productos')->onDelete('cascade');
            $table->foreignId('comprador_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('vendedor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('tipo', 50);
            $table->decimal('monto', 10, 2);
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('j2_transacciones');
    }
};
