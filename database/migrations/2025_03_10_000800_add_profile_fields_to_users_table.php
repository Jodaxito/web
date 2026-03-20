<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_perfil')->nullable()->after('email');
            $table->text('bio')->nullable()->after('foto_perfil');
            $table->string('telefono')->nullable()->after('bio');
            $table->boolean('verificado')->default(false)->after('telefono');
            $table->timestamp('verificado_at')->nullable()->after('verificado');
            $table->integer('bloqueado')->default(0)->after('verificado_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto_perfil', 'bio', 'telefono', 'verificado', 'verificado_at', 'bloqueado']);
        });
    }
};
