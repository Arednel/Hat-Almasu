<!DOCTYPE html>
<html>

<head>
    <title>Авторизация</title>

    <link rel="stylesheet" type="text/css" href="../css/loginForm.css">
</head>

<body>

    <form action="login.php" method="post">
        <h2>Авторизация</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="message"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <label>Логин</label>
        <input type="text" name="userName" placeholder="User Name"><br>

        <label>Пароль</label>
        <input type="password" name="userPassword" placeholder="Password"><br>

        <a href="index.php" class="buttonLink">На главную</a>

        <button type="submit">Войти</button>
    </form>

</body>

</html>