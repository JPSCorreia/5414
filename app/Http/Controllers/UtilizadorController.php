<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use Illuminate\Http\Request;
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
        return view('users.index', ['utilizadores' => $utilizadores]);

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

    // Criar novo utilizador
    public function store(Request $request)
    {
        Log::info('A tentar criar um novo utilizador, a validar dados enviados no request: ', $request->all());

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilizadores',
            'password' => 'required|string|min:8',
            'distrito' => 'required|string|max:255',
            'concelho' => 'required|string|max:255',
            'admin' => 'boolean',
        ]);

        Log::info('Dados validados com sucesso, a tentar criar novo utilizador...');
    
        $utilizador = Utilizador::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar a password
            'distrito' => $request->distrito,
            'concelho' => $request->concelho,
            'admin' => $request->admin ?? 0, // O valor default será 0 (não administrador)
        ]);

        Log::info('Utilizador criado com sucesso: ' . $request->email);
    
        return response()->json($utilizador, 201);
    }

    // Atualizar utilizador existente
    public function update(Request $request, $id) 
    {
        Log::info('A tentar atualizar o utilizador com ID: ' . $id);

        $utilizador = Utilizador::find($id);

        if (!$utilizador) {
            Log::error('Utilizador com ID ' . $id . ' não encontrado');
            return response()->json(['message' => 'Utilizador não encontrado'], 404);
        }

        Log::info('A tentar validar dados enviados no request: ', $request->all());

        $request->validate([
            'nome' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'distrito' => 'required|string|max:255',
            'concelho' => 'required|string|max:255'
        ]);

        Log::info('Dados validados com sucesso, a tentar actualizar...');

        $utilizador->update([
            'nome' => $request->nome,
            'password' => Hash::make($request->password), // Encriptar a password
            'distrito' => $request->distrito,
            'concelho' => $request->concelho,
        ]);

        Log::info('Utilizador atualizado com sucesso: ' . $utilizador->id);

        return response()->json($utilizador, 200);
    }

    // Eliminar utilizador existente
    public function destroy($id)
    {
        Log::info('A tentar procurar o utilizador para eliminar com ID: ' . $id);

        $utilizador = Utilizador::find($id);

        if (!$utilizador) {
            Log::error('Utilizador com ID ' . $id . ' não encontrado');

            return response()->json(['message' => 'Utilizador não encontrado'], 404);
        }

        Log::info('A tentar eliminar o utilizador com ID: ' . $id);

        if ($utilizador->delete()) {
            Log::info('Utilizador eliminado com sucesso: ' . $utilizador->id);
            
            return response()->json(['message' => 'Utilizador eliminado com sucesso'], 200);
        }

        Log::error('Ocorreu um erro ao eliminar o utilizador');

        return response()->json(['message' => 'Ocorreu um erro ao eliminar o utilizador'], 500);
    }
}
