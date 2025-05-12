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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('conteudo')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('chamada_curta')->nullable();
            $table->string('link_video')->nullable();
            $table->boolean('ativo')->default(false);
            $table->boolean('exibir_franqueado')->default(true);
            $table->string('imagem_principal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
