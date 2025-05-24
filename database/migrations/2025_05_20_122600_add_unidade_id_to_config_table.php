<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Verifica se a coluna já existe
        if (!Schema::hasColumn('config', 'unidade_id')) {
            // Primeiro adiciona a coluna sem a restrição
            Schema::table('config', function (Blueprint $table) {
                $table->unsignedBigInteger('unidade_id')->nullable()->after('id');
            });
        }

        // Atualiza os registros existentes para apontar para a unidade MASTER
        $unidadeMaster = DB::table('unidades')->where('nome', 'MASTER')->first();
        if ($unidadeMaster) {
            DB::table('config')->update(['unidade_id' => $unidadeMaster->id]);
        }

        // Tenta adicionar a chave estrangeira
        try {
            Schema::table('config', function (Blueprint $table) {
                $table->foreign('unidade_id')
                      ->references('id')
                      ->on('unidades')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Se der erro, provavelmente a chave já existe
            // Podemos ignorar o erro
        }
    }

    public function down(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->dropForeign(['unidade_id']);
            $table->dropColumn('unidade_id');
        });
    }
};
