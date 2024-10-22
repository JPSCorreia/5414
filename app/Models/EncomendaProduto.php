<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EncomendaProduto extends Model
{
    use HasFactory;
    protected $table = 'encomenda_produto'; // Nome da tabela correta

    // Definindo os atributos que podem ser preenchidos em massa
    protected $fillable = ['encomenda_id', 'produto_id', 'quantidade'];

    // Relacionamento com a encomenda
    public function encomenda()
    {
        return $this->belongsTo(Encomenda::class, 'encomenda_id');
    }

    // Relacionamento com o produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}