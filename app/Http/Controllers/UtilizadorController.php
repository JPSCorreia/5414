<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UtilizadorController extends Controller
{
    // Listar todos os utilizadores
    public function index()
    {
        Log::info('A tentar encontrar todos os utilizadores');

        $utilizadores = Utilizador::all();

        Log::info('Utilizadores encontrados com sucesso.');

        // Verify if the request expects JSON
        if (request()->wantsJson()) {
            Log::info('A tentar retornar os utilizadores como JSON');
            return response()->json($utilizadores);
        }

        Log::info('A tentar retornar os utilizadores como HTML');

        // return view('utilizadores.index', ['utilizadores' => $utilizadores]);

        // Alternativa:
        // return view('users.index', compact('utilizadores'));

    }

    // Mostrar um utilizador específico
    public function show($id)
    {
        Log::info('A tentar encontrar o utilizador: ' . $id);

        $utilizador = Utilizador::find($id);

        if (!$utilizador) {
            Log::error('Utilizador com ID ' . $id . ' não encontrado');
            return response()->json(['message' => 'Utilizador não encontrado'], 404);
        }

        Log::info('Utilizador encontrado: ' . $id);

        return response()->json($utilizador);
    }

    // Criar um novo utilizador a partir da página de administração
    public function store(Request $request)
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

    // Actualizar utilizador existente
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

    // Eliminar utilizador existente
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
