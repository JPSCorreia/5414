<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    // Define o nome da tabela associada ao modelo
    protected $table = 'encomendas';

    // Definir os campos que podem ser preenchidos
    protected $fillable = [
        'utilizador_id',
        'produto_id',
        'quantidade',
    ];

    // Definir os timestamps personalizados
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'actualizado_em';

    // Relacionamento com utilizador (Uma encomenda pertence a um utilizador)
    public function utilizador()
    {
        return $this->belongsTo(Utilizador::class, 'utilizador_id');
    }

    // Relacionamento com produto (Uma encomenda refere-se a um produto)
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
