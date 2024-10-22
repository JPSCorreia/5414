<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('encomendas', function (Blueprint $table) {
            $table->id();  // Chave primária
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com utilizadores
            $table->dateTime('data_encomenda');  // Data da encomenda
            $table->timestamps();  // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomendas');
    }
};
