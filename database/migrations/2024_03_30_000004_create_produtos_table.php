<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('imagem')->nullable();
            $table->string('slug')->unique();
            $table->boolean('ativo')->default(true);

            // marca_id opcional
            $table->foreignId('marca_id')->nullable()->constrained()->onDelete('set null');

            // categoria_id opcional
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
}; 