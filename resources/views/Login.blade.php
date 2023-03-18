<!DOCTYPE html>
<html>

<head>
    <title>Авторизация</title>

    <link rel="stylesheet" href="{{ asset('css/loginForm.css') }}">
</head>

<body>

    <form action="LoginLogic" method="post">
        <h2>Авторизация</h2>

        @php
            if (isset($_GET['error'])) {
                echo '<p class="message"> echo ' . $_GET['error'] . '</p>';
            }
        @endphp

        <label>Логин</label>
        <input type="text" name="userName" placeholder="User Name"><br>

        <label>Пароль</label>
        <input type="password" name="userPassword" placeholder="Password"><br>

        <a href="/" class="buttonLink">На главную</a>

        <button type="submit">Войти</button>
    </form>

</body>

</html>
