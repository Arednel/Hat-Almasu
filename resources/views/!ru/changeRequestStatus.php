<?php
require "../privileges/support.php";
require "../db_conn.php";

$requestID = $_GET['requestID'];
$isApproved = $_GET['isApproved'];

$query = 'SELECT `isApproved` FROM requests WHERE requestID = ' . $requestID . '';
$result = mysqli_query($conn, $query);
while ($record = mysqli_fetch_assoc($result)) {
    $requestIsApprovedStatus = $record['isApproved'];
}
switch ($requestIsApprovedStatus) {
    case "0":
        $status = "new";
        break;
    case "1":
        $status = "approved";
        break;
    case "2":
        header("Location: index.php?error=Нельзя изменить статус, студент уже выбрал дату пересдачи");

        exit();
        break;
    case "5":
        $status = "rejected";
        break;
}

if ($isApproved == "1") {
    $query = 'UPDATE requests SET isApproved = 1 WHERE requestID = ' . $requestID . '';
    $result = mysqli_query($conn, $query);
} else if ($isApproved == "0") {
    $query = 'UPDATE requests SET isApproved = 5 WHERE requestID = ' . $requestID . '';
    $result = mysqli_query($conn, $query);
} else {
    header("Location: index.php?error=Ошибка изменения статуса заявки");

    exit();
}

header("Location: requests.php?status=$status");
