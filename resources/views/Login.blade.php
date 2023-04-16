<!DOCTYPE html>

<html>

<head>
    <title>Авторизация</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/LoginForm.css') }}">
</head>

<body>
    <form method="POST" action="LoginLogic" method="post">
        <h2>Авторизация</h2>

        @csrf

        @if (isset($_GET['error']))
            <p class="message">{{ $_GET['error'] }}</p>
        @endif

        <label>Логин</label>
        <input type="text" name="username" placeholder="User Name" required><br>

        <label>Пароль</label>
        <input type="password" name="password" placeholder="Password" required><br>

        <a href="/" class="buttonLink">На главную</a>

        <button type="submit">Войти</button>
    </form>
</body>

</html>
