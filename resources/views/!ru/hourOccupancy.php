<!DOCTYPE html>

<html>

<head>
    <title>Выбор времени</title>

    <link rel="stylesheet" href="../css/main.css">
</head>


<?php
require "../db_conn.php";
require "../privileges/admin.php";
require "topBottom/navBar.php";
require "topBottom/footer.html";

$_SESSION['chosenDate'] = '"' . $_COOKIE['chosenDate'] . '"';

$chosenDate = str_replace('"', '', $_SESSION['chosenDate']);

//Проверка, стоит ли этот день онлайн
$query = "SELECT isOnline FROM availabledates WHERE `date` = '$chosenDate'";
$result = mysqli_query($conn, $query);
$record = mysqli_fetch_assoc($result);
if ($record['isOnline']) {
    header("Location: watchOccupancyOnline.php");

    exit();
}
//Проверка, стоит ли этот день онлайн
?>


<style>
    .table td {
        line-height: 1.5;
    }

    .table-body td {
        padding: 0;
    }

    input:hover {
        background-color: #21abc4 !important;
    }
</style>

<body>
    <div class="main-body">
        <table class="table">
            <thead class="table-head">
                <tr>
                    <th class="column" colspan="100%"><?php
                                                        echo $chosenDate;
                                                        ?>
                        / Выберите время</th>
                </tr>
            </thead>
            <thead class="table-head">
                <tr>
                    <th class="column">Время / Аудитория </th>
                    <th class="column">Всего / Свободно / Занято мест</th>
                    <th class="column-short">Нажмите, чтобы перейти</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                $hoursArray = array();

                $query = "SELECT startHour, endHour FROM availabledates WHERE `date` = '$chosenDate'";
                $result1 = mysqli_query($conn, $query);
                $record = mysqli_fetch_assoc($result1);

                $startHour = $record['startHour'];
                $endHour = $startHour + 1;
                while ($startHour < $record['endHour']) {
                    $query = "SELECT roomID, roomName, roomSpace FROM rooms";
                    $result2 = mysqli_query($conn, $query);

                    while ($rooms = mysqli_fetch_assoc($result2)) {
                        $roomSpace = $rooms['roomSpace'];
                        $roomID = $rooms['roomID'];
                        //$roomID==1 это онлайн
                        if (!($roomID == 1)) {
                            $bookingDate = $_SESSION['chosenDate'];
                            $query = "SELECT roomID FROM bookingrecords WHERE bookingdate = " . $bookingDate . " AND startHour = $startHour AND roomID = $roomID";
                            $result3 = mysqli_query($conn, $query);

                            while ($roomSpaces = mysqli_fetch_assoc($result3)) {
                                $roomSpace--;
                            }
                            $roomsOccupied = $rooms['roomSpace'] - $roomSpace;
                            echo '<tr>
                             <td class="column">
                                 &nbsp&nbspC ' . $startHour . ':00 до ' . $endHour . ':00 / ' . $rooms['roomName'] . '
                             </td>
                             <td class="column">
                             &nbsp&nbspВсего ' . $rooms['roomSpace'] . ' / Свободно ' . $roomSpace . ' / Занято ' . $roomsOccupied . '
                             </td>';

                            echo '<td class="column-short">
                                 <input onclick="watchOccupancy(' . $startHour . ', ' . $roomID . ')" type="button" value="Посмотреть" class="calendar-button">                    
                             </td>';
                        }
                    }
                    $startHour++;
                    $endHour++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

<script src="../scripts/watchOccupancy.js"></script>

</html>