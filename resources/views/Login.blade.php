<!DOCTYPE html>
<html>

<head>
    <title>Авторизация</title>

    <link rel="stylesheet" href="{{ asset('css/LoginForm.css') }}">
</head>

<body>

    <form method="POST" action="LoginLogic" method="post">
        <h2>Авторизация</h2>

        @csrf

        @php
            if (isset($_GET['error'])) {
                echo '<p class="message">' . $_GET['error'] . '</p>';
            }
        @endphp

        <label>Логин</label>
        <input type="text" name="userName" placeholder="User Name" required><br>

        <label>Пароль</label>
        <input type="password" name="userPassword" placeholder="Password" required><br>

        <a href="/" class="buttonLink">На главную</a>

        <button type="submit">Войти</button>
    </form>

</body>

</html>
