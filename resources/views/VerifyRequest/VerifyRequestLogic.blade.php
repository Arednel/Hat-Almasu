<?php
if (isset($_POST["mail"])) {
    $mail = $_POST["mail"];
    $requestID = $_POST["requestID"];

    $query = 'SELECT mail, isApproved FROM requests WHERE requestID = ' . $requestID . '';
    $result = mysqli_query($conn, $query);
    while ($record = mysqli_fetch_assoc($result)) {
        if ($record['mail'] == $mail && $record['isApproved'] == 1) {
            $_SESSION['requestID'] = $requestID;
            $_SESSION['mail'] = $mail;
            header("Location: date.php");

            exit();
        } else if ($record['mail'] == $mail && $record['isApproved'] == 0) {
            header("Location: index.php?messageokay=Заявка рассматривается");

            exit();
        } else if ($record['mail'] == $mail && $record['isApproved'] == 2) {
            header("Location: index.php?error=Вы уже выбрали время");

            exit();
        } else if ($record['mail'] == $mail && $record['isApproved'] == 5) {
            header("Location: index.php?error=Заявка была отклонена");

            exit();
        } else {
            header("Location: index.php?error=Неверные данные почты");

            exit();
        }
    }
    header("Location: index.php?error=Заявки не существует");

    exit();
}
