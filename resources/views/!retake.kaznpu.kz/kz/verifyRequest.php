<!DOCTYPE html>

<html>

<head>
    <title>Қолданба күйі</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/manageForm.css">
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../db_conn.php";
require "verifyRequest/verifyRequestLogic.php";
?>

<style>
    .formInputs {
        grid-column: 1 / 3;
    }

    a:link,
    a:visited {
        padding-bottom: 0;
        height: 6vh;
    }
</style>

<body>
    <div class="main-body">

        <div class="modal-content">
            <img src="../images/3.jpg" class="formImage">

            <?php
            require "verifyRequest/verifyRequestForm.php";
            ?>
        </div>
    </div>
</body>


</html>