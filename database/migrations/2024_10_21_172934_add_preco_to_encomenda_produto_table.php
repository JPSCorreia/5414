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
        Schema::table('encomenda_produto', function (Blueprint $table) {
            $table->decimal('preco', 8, 2)->nullable(); // ajusta o tipo conforme necessário
        });
    }
    
    public function down()
    {
        Schema::table('encomenda_produto', function (Blueprint $table) {
            $table->dropColumn('preco');
        });
    }
    
};
