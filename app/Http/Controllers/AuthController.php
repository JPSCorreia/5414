<?php
namespace App\Http\Controllers;

use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar o formulário de registo
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Registar um novo utilizador
    public function register(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilizadores',
            'password' => 'required|string|min:8|confirmed',
            'distrito' => 'required|string|max:255',
            'concelho' => 'required|string|max:255'
        ]);

        // Criar o novo utilizador
        $utilizador = Utilizador::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'distrito' => $request->distrito,
            'concelho' => $request->concelho
        ]);

        // Fazer login automaticamente após o registo
        Auth::login($utilizador);

        // Redirecionar para o perfil ou outra página
        return redirect('/perfil')->with('success', 'Registo concluído com sucesso!');
    }

    // Mostrar o formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login de utilizador
    public function login(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tentar autenticar o utilizador
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirecionar para o perfil ou homepage
            return redirect('/perfil')->with('success', 'Login realizado com sucesso!');
        }

        // Se falhar o login
        return back()->withErrors(['email' => 'As credenciais não correspondem.']);
    }

    // Logout do utilizador
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout realizado com sucesso!');
    }
}
