<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET every user.
    public function index()
    {
        $utilizadores = User::all(); // Get all users
        return response()->json($utilizadores); // Return all users
    }

    // GET specific user.
    public function show($id)
    {
        $utilizador = User::find($id); // Find the user with the given id
        
        if ($utilizador) {
            return response()->json($utilizador); // Returns the found user
        } else {
            return response()->json(['message' => 'Utilizador não encontrado'], 404); // if user not found, return message: User Not Found
        }
    }

    public function store(Request $request)
    {
        // Data validation
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilizadores',  // Verifica o nome correto da tabela
            'password' => 'required|string|min:8',
            'distrito' => 'required|string|max:255',
            'concelho' => 'required|string|max:255',
            'admin' => 'boolean', // Podes adicionar validação para o campo 'admin' se necessário
        ]);
    
        // User creation
        $utilizador = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar a password
            'distrito' => $request->distrito,
            'concelho' => $request->concelho,
            'admin' => $request->admin ?? 0, // O valor default será 0 (não administrador)
        ]);
    
        // Return user created
        return response()->json($utilizador, 201);  // 201 indica que o recurso foi criado
    }
    
}
