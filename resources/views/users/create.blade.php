<h1>Novo Usuário</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    Nome: <input type="text" name="name"><br><br>
    Email: <input type="email" name="email"><br><br>
    Telefone: <input type="text" name="telefone"><br><br>
    Senha: <input type="password" name="password"><br><br>

    <button type="submit">Salvar</button>
</form>
