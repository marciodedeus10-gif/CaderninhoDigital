<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

    <h2>Login</h2>

    @if ($errors->any())
        <div>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" placeholder="Email" required>
        <br><br>

        <input type="password" name="password" placeholder="Senha" required>
        <br><br>

        <button type="submit">Entrar</button>
    </form>

    <a href="{{ route('register') }}">Criar Conta</a>

</body>

</html>
