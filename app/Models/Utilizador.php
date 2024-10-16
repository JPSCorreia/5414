<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilizador extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define o nome da tabela associada ao modelo
    protected $table = 'utilizadores';

    // Definir os timestamps personalizados
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'actualizado_em';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
        'distrito',
        'concelho',
        'admin'
    ];
}
