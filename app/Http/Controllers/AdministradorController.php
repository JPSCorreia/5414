<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdministradorController extends Controller
{
    // Listar pagina de administrador
    public function index(Request $request)
    {
        $query = Utilizador::query();

        // Filtrar por distrito
        if ($request->filled('distrito')) {
            $query->where('distrito', $request->distrito);
        }

        // Filtrar por concelho
        if ($request->filled('concelho')) {
            $query->where('concelho', $request->concelho);
        }

        // Obter utilizadores filtrados
        $utilizadores = $query->get();

        // Obter listas únicas de distritos e concelhos para os filtros
        $distritos = Utilizador::select('distrito')->distinct()->pluck('distrito');
        $concelhos = Utilizador::select('concelho')->distinct()->pluck('concelho');

        return view('administrador.index', compact('utilizadores', 'distritos', 'concelhos'));
    }

    public function update(Request $request, $id)
    {
        $utilizador = Utilizador::find($id);

        if (!$utilizador) {
            return response()->json(['success' => false, 'message' => 'Utilizador não encontrado.'], 404);
        }

        // Atualizar os dados do utilizador com base no request
        $utilizador->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'distrito' => $request->distrito,
            'concelho' => $request->concelho,
            'admin' => $request->admin
        ]);

        return response()->json(['success' => true, 'message' => 'Utilizador atualizado com sucesso.', 'utilizador' => $utilizador]);
    }

    // Função para criar um novo utilizador a partir da página de administração
    public function create(Request $request)
    {
        Log::info('A tentar criar um novo utilizador a partir da página de administração, a validar os dados enviados no request.', $request->all());

        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilizadores',
            'password' => 'required|string|min:8',
            'distrito' => 'required|string|max:255',
            'concelho' => 'required|string|max:255',
            'admin' => 'nullable|boolean'
        ]);

        Log::info('Dados validados com sucesso, a tentar criar novo utilizador...');

        // Criação do utilizador
        $utilizador = Utilizador::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'distrito' => $request->distrito,
            'concelho' => $request->concelho,
            'admin' => $request->has('admin') ? 1 : 0
        ]);

        Log::info('Utilizador criado com sucesso: ' . $request->email);

        // Resposta JSON para o JavaScript
        return response()->json([
            'success' => true,
            'utilizador' => $utilizador
        ], 201);
    }

    public function destroy($id)
    {
        $utilizador = Utilizador::find($id);

        if (!$utilizador) {
            return response()->json(['success' => false, 'message' => 'Utilizador não encontrado.'], 404);
        }

        $utilizador->delete();

        return response()->json(['success' => true, 'message' => 'Utilizador apagado com sucesso.']);
    }

}