<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImagensProduto;

class Produto extends Model
{
    use HasFactory;
    // Define o nome da tabela associada ao modelo
    protected $table = 'produtos';
    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'titulo',
        'descricao',
        'preco',
        'categoria_id',
    ];
    // Definir os timestamps personalizados
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'actualizado_em';
    // Relacionamento com categoria (Muitos produtos pertencem a uma categoria)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    // Relacionamento com imagens (Um produto tem muitas imagens)
    public function imagens()
    {
        return $this->hasMany(ImagensProduto::class, 'produto_id');
    }
    //Este método indica que um produto pode pertencer a várias encomendas.
    public function encomendas()
    {
        return $this->belongsToMany(Encomenda::class, 'encomenda_produto')->withPivot('quantidade');
    }
}
