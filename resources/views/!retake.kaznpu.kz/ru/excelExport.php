<?php
require "../db_conn.php";
require "../privileges/viewer.php";

if ($_POST['statusType'] == "new") {
    $where = "WHERE isApproved = 0";
    $filenameType = "New_All";
} else if ($_POST['statusType'] == "approved") {
    $where = "WHERE isApproved = 1 OR isApproved = 2";
    $filenameType = "Approved_All";
} else if ($_POST['statusType'] == "rejected") {
    $where = " WHERE isApproved = 5";
    $filenameType = "Rejected_All";
}
if (isset($_POST['offSet'])) {
    $offSet = $_POST['offSet'];
    $perPage = $_POST['perPage'];
    $where .= " LIMIT $offSet,$perPage";
    $filenameType = str_replace('_All', '', $filenameType);
}

$filename = "Requests_" . $filenameType . "_" . date('Y/m/d') . ".xls";

header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: application/vnd.ms-excel");
header("Pragma: no-cache");
header("Expires: 0");

$heading = false;

function cleanData(&$str)
{
    // escape tab characters
    $str = preg_replace("/\t/", "", $str);

    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);
}

$query = "SELECT 
requestID, idOfTest, faculty, fullName, 
speciality, course, department, `subject`, 
mail, phoneNumber, reason 
FROM requests 
" . $where;

$result = mysqli_query($conn, $query);

while ($record = mysqli_fetch_assoc($result)) {
    $requestID = $record['requestID'];
    $idOfTest = $record['idOfTest'];
    $faculty = $record['faculty'];
    $fullName = $record['fullName'];
    $speciality = $record['speciality'];
    $course = $record['course'];
    $department = $record['department'];
    $subject = $record['subject'];
    $mail = $record['mail'];
    $phoneNumber = $record['phoneNumber'];
    $reason = $record['reason'];

    $data = array(
        "ID заявки" => "$requestID",
        "ID теста" => "$idOfTest",
        "Институт" => "$faculty",
        "ФИО" => "$fullName",
        "Специальность" => "$speciality",
        "Курс" => "$course",
        "Отделение" => "$department",
        "Дисциплина" => "$subject",
        "Email" => "$mail",
        "Телефон" => "$phoneNumber",
        "Причина" => "$reason"
    );

    array_walk($data, __NAMESPACE__ . '\cleanData');

    if (!$heading) {
        echo implode("\t", array_keys($data)) . "\r\n";
        $heading = true;
    }
    echo implode("\t", array_values($data)) . "\r\n";
}

exit;
