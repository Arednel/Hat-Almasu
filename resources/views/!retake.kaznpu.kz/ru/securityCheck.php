<?php
// Проверка, введён ли правильный текст
if (isset($_SESSION['requestID'])) {
    $requestID = $_SESSION['requestID'];
    $mail = $_SESSION['mail'];

    $query = 'SELECT mail, isApproved FROM requests WHERE requestID = ' . $requestID . '';
    $result = mysqli_query($conn, $query);

    while ($record = mysqli_fetch_assoc($result)) {
        if (!($record['mail'] == $mail && $record['isApproved'] == 1)) {
            header("Location: index.php?error=Ошибка");

            exit();
        }
    }
} else {
    header("Location: index.php?error=Ошибка");

    exit();
}
