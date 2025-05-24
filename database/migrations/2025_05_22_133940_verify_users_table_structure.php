<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verifica se a coluna role existe
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'franqueado'])->default('franqueado')->after('password');
            });
        }

        // Verifica se a coluna unidade_id existe
        if (!Schema::hasColumn('users', 'unidade_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('unidade_id')->nullable()->after('role')->constrained()->onDelete('set null');
            });
        }

        // Atualiza registros existentes que não têm role definido
        DB::table('users')->whereNull('role')->update(['role' => 'franqueado']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não é necessário reverter as alterações pois são correções estruturais
    }
};
