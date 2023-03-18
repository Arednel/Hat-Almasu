<!DOCTYPE html>

<html>

<head>
    <title>Список доступных дат</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/employeeFandT.css">
    <link rel="stylesheet" href="../css/betterTableManage.css">
</head>

<?php
require "../db_conn.php";
require "../privileges/admin.php";
require "topBottom/navBar.php";
require "topBottom/footer.html";
require "tableAddNew.html";
require "manage/manageDates/manageDatesLogic.php";
?>

<body>
    <div class="main-body">
        <table class="table">
            <thead class="table-head">
                <tr>
                    <th class="column">Дата <img src="../images/sort.png" class="Sort" /></th>
                    <th class="column">С / До <img src="../images/sort.png" class="Sort" /></th>
                    <th class="column">Онлайн <img src="../images/sort.png" class="Sort" /></th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                $query = 'SELECT * FROM availabledates ORDER BY `date`';
                $result = mysqli_query($conn, $query);

                while ($record = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                                    <td class="column">' . $record['date'] . '</td>
                                    <td class="column">С ' . $record['startHour'] . ':00 до ' . $record['endHour'] . ':00</td>';
                    if ($record['isOnline']) {
                        echo '<td class="column">✓</td>';
                    } else {
                        echo '<td class="column">X</td>';
                    }
                    echo ' </tr>';
                }
                ?>
            </tbody>
        </table>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <?php
                require "manage/manageDates/manageDatesForm.php";
                ?>
            </div>
        </div>
    </div>

</body>

<script src="../scripts/modalWindow.js"></script>
<script src="../scripts/sort.js"></script>

</html>