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
        Schema::create('encomenda_produto', function (Blueprint $table) {
            $table->id();  // Chave primária
            $table->foreignId('encomenda_id')->constrained()->onDelete('cascade');  // Relacionamento com encomendas
            $table->foreignId('produto_id')->constrained()->onDelete('cascade');  // Relacionamento com produtos
            $table->integer('quantidade');  // Quantidade de produtos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomenda_produto');
    }
};
