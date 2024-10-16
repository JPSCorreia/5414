<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Utilizadores</title>
</head>
<body>
    <h1>Lista de Utilizadores</h1>
    
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Distrito</th>
                <th>Concelho</th>
                <th>Admin</th>
                <th>Último Login</th>
                <th>Criado Em</th>
                <th>Atualizado Em</th>
            </tr>
        </thead>
        <tbody>
            @foreach($utilizadores as $utilizador)
                <tr>
                    <td>{{ $utilizador->id }}</td>
                    <td>{{ $utilizador->nome }}</td>
                    <td>{{ $utilizador->email }}</td>
                    <td>{{ $utilizador->distrito }}</td>
                    <td>{{ $utilizador->concelho }}</td>
                    <td>{{ $utilizador->admin ? 'Sim' : 'Não' }}</td>
                    <td>{{ $utilizador->ultimo_login ?? 'N/A' }}</td>
                    <td>{{ $utilizador->criado_em }}</td>
                    <td>{{ $utilizador->actualizado_em }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
