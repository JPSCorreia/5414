<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use App\Models\Utilizador; 


class Encomenda extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id', 'data_encomenda'];

    // Relacionamento com o utilizador
    public function utilizador() // Usa 'utilizador' em vez de 'user'
    {
        return $this->belongsTo(Utilizador::class, 'user_id'); // Corrige aqui
    }

    // Relacionamento com produtos (muitos para muitos)
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'encomenda_produto')->withPivot('quantidade');
    }
}
