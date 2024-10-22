<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encomenda;
use App\Models\Produto;
use App\Models\Utilizador;
use Carbon\Carbon;

class EncomendaSeeder extends Seeder
{
    public function run()
    {
        
        $utilizadores = Utilizador::all();
        $produtos = Produto::all();

        // Criar 6 encomendas
        for ($i = 1; $i <= 6; $i++) {
            $encomenda = Encomenda::create([
                'user_id' => $utilizadores->random()->id, 
                'data_encomenda' => Carbon::now()->subDays($i), 
                'total' => rand(50, 300), 
            ]);

            // Associar produtos aleatórios à encomenda
            $produtosAleatorios = $produtos->random(rand(1, 5)); // Entre 1 e 5 produtos
            foreach ($produtosAleatorios as $produto) {
                $encomenda->produtos()->attach($produto->id, [
                    'quantidade' => rand(1, 3), // Quantidade aleatória
                    'preco' => $produto->preco, // Preço do produto na encomenda
                ]);
            }
        }
    }
}
