<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../../db_conn.php";

require "../securityCheck.php";

$bookingDate = $_SESSION['chosenDate'];
$startHour = $_COOKIE['startHour'];
$roomID = $_COOKIE['roomID'];

$query = 'SELECT roomName FROM rooms WHERE roomID = ' . $roomID . '';
$result = mysqli_query($conn, $query);
$record = mysqli_fetch_assoc($result);
$roomName = $record['roomName'];

$query = 'UPDATE requests SET isApproved = 2 WHERE requestID = ' . $requestID . '';
$result = mysqli_query($conn, $query);

$query = "INSERT INTO bookingrecords (bookingdate, requestID, startHour, roomID) 
VALUES ($bookingDate, $requestID, $startHour, $roomID)";
$result = mysqli_query($conn, $query);

$endHour = $startHour + 1;
$chosenDate = str_replace('"', '', $_SESSION['chosenDate']);

header("Location: ../index.php?message=Қайта қабылдау уақытын сәтті таңдадыңыз, $chosenDate, С $startHour:00 до $endHour:00, Аудитория: $roomName");
