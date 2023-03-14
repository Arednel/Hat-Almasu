<!DOCTYPE html>

<html>

<head>
    <title>Уақытты таңдау</title>

    <link rel="stylesheet" href="../css/main.css">
</head>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../db_conn.php";
require "topBottom/navBar.php";
require "topBottom/footer.html";

require "securityCheck.php";

$_SESSION['chosenDate'] = '"' . $_COOKIE['chosenDate'] . '"';

$chosenDate = str_replace('"', '', $_SESSION['chosenDate']);
?>


<style>
    .table-body td {
        padding: 0;
    }

    .calendar-button-green:hover {
        background-color: #21abc4 !important;
    }

    tr:hover {
        background-color: white !important;
    }

    @media (max-device-width: 850px) {
        .table td {
            line-height: 1.1;
        }

        .calendar-button-green,
        .calendar-button-red {
            padding-top: 8vh;
            padding-bottom: 8vh;
        }
    }
</style>

<body>
    <div class="main-body">
        <?php
        //Проверка, стоит ли этот день онлайн
        $query = "SELECT isOnline FROM availabledates WHERE `date` = '$chosenDate'";
        $result = mysqli_query($conn, $query);
        $record = mysqli_fetch_assoc($result);
        if ($record['isOnline']) {
            require "register/registerOnline.php";
        } else {
            require "register/registerNotOnline.php";
        }
        //Проверка, стоит ли этот день онлайн
        ?>
    </div>
</body>

<script src="../scripts/registerLogic.js"></script>

</html>