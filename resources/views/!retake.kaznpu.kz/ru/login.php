<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../db_conn.php";

if (isset($_POST['userName']) && isset($_POST['userPassword'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    $uname = validate($_POST['userName']);
    $pass = validate($_POST['userPassword']);

    if (empty($uname)) {
        header("Location: loginForm.php?error=User Name is required");

        exit();
    } else if (empty($pass)) {
        header("Location: loginForm.php?error=Password is required");

        exit();
    } else {
        $query = "SELECT * FROM users WHERE userName='$uname' AND userPassword='$pass'";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['userName'] === $uname && $row['userPassword'] === $pass) {
                echo "Logged in!";

                $_SESSION['userName'] = $row['userName'];
                $_SESSION['userID'] = $row['userID'];
                $_SESSION['userPrivilege'] = $row['userPrivilege'];

                header("Location: /ru/index.php");

                exit();
            } else {
                header("Location: loginForm.php?error=Неверный логин или пароль");

                exit();
            }
        } else {
            header("Location: loginForm.php?error=Неверный логин или пароль");

            exit();
        }
    }
} else {
    header("Location: loginForm.php?error=Unknown Error");

    exit();
}
