<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
</head>
<body>

<h2>Cadastro</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <input type="text" name="name" placeholder="Nome" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Senha" required>
    <br><br>

    <input type="password" name="password_confirmation" placeholder="Confirmar Senha" required>
    <br><br>

    <button type="submit">Cadastrar</button>
</form>

<a href="{{ route('login') }}">Voltar</a>

</body>
</html>