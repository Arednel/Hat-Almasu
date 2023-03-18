<?php
if (isset($_POST["year"])) {
    $year = $_POST["year"];
    $month = $_POST["month"];
    $day = $_POST["day"];
    $startHour = $_POST["startHour"];
    $endHour = $_POST["endHour"];
    if (isset($_POST['isOnline']) && $_POST['isOnline'] == "1") {
        $isOnline = 1;
    } else {
        $isOnline = 0;
    }

    if ($endHour < $startHour) {
        $endHour = $startHour + 1;
    }

    $fullDate = strval($year);
    $fullDate .= ".";
    $fullDate .= strval($month);
    $fullDate .= ".";

    if ($day < 10) {
        $day = "0" . strval($day);
        $fullDate .= $day;
    } else {
        $fullDate .= strval($day);
    }

    $query = "INSERT INTO availabledates(`date`, startHour, endHour, isOnline) 
    VALUES ('$fullDate', $startHour, $endHour, $isOnline)";
    mysqli_query($conn, $query);
}

if (isset($_POST["date"])) {
    $date = $_POST["date"];

    $query = "DELETE FROM availabledates WHERE `date`='$date'";
    mysqli_query($conn, $query);
}
