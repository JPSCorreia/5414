<?php
namespace App\Http\Controllers;

use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        Log::info('A tentar criar um novo utilizador, a validar dados enviados no request: ', $request->all());

        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilizadores',
            'password' => 'required|string|min:8|confirmed',
            'distrito' => 'required|string|max:255',
            'concelho' => 'required|string|max:255',
            'admin' => 'nullable|boolean'
        ]);

        Log::info('Dados validados com sucesso, a tentar criar novo utilizador...');

        // Criar o novo utilizador
        $utilizador = Utilizador::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'distrito' => $request->distrito,
            'concelho' => $request->concelho,
            'admin' => $request->has('admin') ? 1 : 0
        ]);

        Log::info('Utilizador criado com sucesso: ' . $request->email);

        // Verificar se o request espera JSON
        if (request()->wantsJson()) {
            return response()->json($utilizador, 201);
        }

        // Fazer login automaticamente após o registo
        Auth::login($utilizador);

        Log::info('Autenticado com sucesso: ' . $request->email);

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

            // Obter o utilizador autenticado
            $utilizador = Auth::user();

            // Atualizar o campo ultimo_login com a hora atual
            $utilizador->ultimo_login = now();
            $utilizador->save(); // Guardar as alterações


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
