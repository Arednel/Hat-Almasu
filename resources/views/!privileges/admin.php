<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['userPrivilege'])) {
    if ($_SESSION['userPrivilege'] != 'Admin') {
        header("Location: loginForm.php?error=Not Admin!");

        exit();
    }
} else {
    header("Location: loginForm.php?error=Ошибка проверки привелегии");

    exit();
}
