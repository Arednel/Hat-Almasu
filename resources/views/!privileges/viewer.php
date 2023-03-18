<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['userPrivilege'])) {
    if ($_SESSION['userPrivilege'] != 'Admin' && $_SESSION['userPrivilege'] != 'Support' && $_SESSION['userPrivilege'] != 'Viewer') {
        header("Location: loginForm.php?error=Not Viewer!");

        exit();
    }
} else {
    header("Location: loginForm.php?error=Ошибка проверки привелегии");

    exit();
}
