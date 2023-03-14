<!DOCTYPE html>

<html>

<head>
    <title>Өтінім беру</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/manageForm.css">
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../db_conn.php";
require "booking/bookingLogic.php";
?>

<body>
    <div class="main-body">
        <div class="modal-content">
            <img src="../images/3.jpg" class="formImage">
            <?php
            require "booking/bookingForm.php";
            ?>
        </div>
    </div>
</body>


</html>