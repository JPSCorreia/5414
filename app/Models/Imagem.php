<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    // Define o nome da tabela associada ao modelo
    protected $table = 'imagens_produtos';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'produto_id',
        'URL_imagem',
    ];

    // Definir os timestamps personalizados
    const CREATED_AT = 'criado_em';

    // Relacionamento com produto (Uma imagem pertence a um produto)
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
