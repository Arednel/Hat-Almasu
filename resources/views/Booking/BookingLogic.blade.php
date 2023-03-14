<?php
//Ограничение на количество запросов
if (isset($_SESSION['lastRequestTime'])) {
    $currentFullTime = date('d-m-Y h:i:s');
    $to_time = strtotime($_SESSION['lastRequestTime']);
    $from_time = strtotime($currentFullTime);
    $diffirenceBetweenTime = round(abs($to_time - $from_time) / 60, 2);
    if ($diffirenceBetweenTime < 3) {
        header("Location: index.php?error=Подождите 3 минуты, перед подачей следующей заявки");

        exit();
    }
}
//Ограничение на количество запросов

if (isset($_POST["fullName"])) {
    $fullName = $_POST["fullName"];
    $idOfTest = $_POST["idOfTest"];
    $faculty = $_POST["faculty"];
    $course = $_POST["course"];
    $department = $_POST["department"];
    $speciality = $_POST["speciality"];
    $subject = $_POST["subject"];
    $mail = $_POST["mail"];
    $phoneNumber = $_POST["phoneNumber"];
    $reason = $_POST["reason"];

    $query = "SELECT fullName, idOfTest FROM requests";
    $result = mysqli_query($conn, $query);
    while ($record = mysqli_fetch_assoc($result)) {
        if ($record['idOfTest'] == $idOfTest && $record['fullName'] == $fullName) {
            header("Location: index.php?error=Вы уже подали заявку");

            exit();
        }
    }

    if (@is_array(getimagesize($_FILES["confirmationFile"]["tmp_name"]))) {
        $uploadedFile = $_FILES["confirmationFile"]["tmp_name"];
        if (filesize($uploadedFile) > 8388608) {
            header("Location: index.php?error=Файл слишком большой");

            exit();
        }
        clearstatcache();

        $bin_string = file_get_contents($_FILES["confirmationFile"]["tmp_name"]);
        $confirmationFile = base64_encode($bin_string);
    } else {
        header("Location: index.php?error=Ошибка с файлом / Файл слишком большой");

        exit();
    }

    //Ограничение на количество запросов
    $_SESSION['lastRequestTime'] = date('d-m-Y h:i:s');
    //Ограничение на количество запросов

    $query = "INSERT INTO requests
    (fullName , idOfTest, faculty, speciality, 
    course, department, `subject`, mail, 
    phoneNumber, reason, confirmationFile, isApproved) 
    VALUES ('$fullName', $idOfTest, '$faculty', '$speciality',
    $course, '$department', '$subject', '$mail', 
    '$phoneNumber', '$reason', '" . $confirmationFile . "', 0)";
    mysqli_query($conn, $query);

    if ($requestID = mysqli_insert_id($conn)) {
        header("Location: index.php?message=Вы успешно подали заявку, ваш номер заявки: $requestID. Сохраните этот номер!");

        exit();
    } else {
        header("Location: index.php?error=Произошла ошибка");

        exit();
    }
}
