<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações — cria a tabela 'categorias'
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id(); // ID autoincremental interno (chave primária)
            $table->string('codigo', 10)->unique(); // Código gerado automaticamente (ex: CAT001)
            $table->string('nome', 100); // Nome da categoria
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverte as migrações
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
