<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{

    public function index()
    {
        $utilizador = Auth::user();
        $encomendas = $utilizador->encomendas()->with('produto')->orderBy('criado_em', 'desc')->get();
        return view('perfil.index', compact('utilizador', 'encomendas'));
    }

    public function actualizar(Request $request)
    {
        // Validação dos dados (exceto o email)
        $request->validate([
            'nome' => 'required|string|max:255',
            'distrito' => 'required|string|max:255',
            'concelho' => 'required|string|max:255',
        ]);

        // Obter o utilizador autenticado
        $utilizador = Auth::user();

        // Atualizar os dados do utilizador
        $utilizador->nome = $request->nome;
        $utilizador->distrito = $request->distrito;
        $utilizador->concelho = $request->concelho;
        $utilizador->save();

        // Retornar mensagem de sucesso
        return back()->with('success', 'Perfil actualizado com sucesso!');
    }

    public function alterarPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $utilizador = Auth::user();

        // Verifica se a password antiga está correta
        if (!Hash::check($request->old_password, $utilizador->password)) {
            return back()->withErrors(['old_password' => 'A password antiga está incorreta.']);
        }

        // Atualiza a password
        $utilizador->password = Hash::make($request->new_password);
        $utilizador->save();

        return back()->with('success', 'Password alterada com sucesso!');
    }
}
