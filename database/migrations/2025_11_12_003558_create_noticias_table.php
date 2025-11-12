<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Cria a tabela de notícias
     */
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();

            // ✅ Campo código (obrigatório e único)
            $table->string('codigo', 50)->unique();

            // ✅ Relacionamento com categoria
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');

            // ✅ Campos obrigatórios
            $table->string('titulo');
            $table->text('descricao');
            $table->string('imagem'); // imagem é obrigatória no Controller

            // ✅ Campos opcionais
            $table->string('resumo')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Remove a tabela
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
}
