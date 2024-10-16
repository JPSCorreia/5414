<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Define o nome da tabela associada ao modelo
    protected $table = 'categorias';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
    ];

    // Definir os timestamps personalizados
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'actualizado_em';

    // Relacionamento com produtos (Uma categoria tem muitos produtos)
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria_id');
    }
}