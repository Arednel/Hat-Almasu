<!DOCTYPE html>

<html>

<head>
    <title>Список аудиторий</title>
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
require "manage/manageRooms/manageRoomsLogic.php";
?>

<body>
    <div class="main-body">
        <table class="table">
            <thead class="table-head">
                <tr>
                    <th class="column">Название Аудитории <img src="../images/sort.png" class="Sort" /></th>
                    <th class="column">Количество мест <img src="../images/sort.png" class="Sort" /></th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                $query = 'SELECT * FROM rooms ORDER BY roomName';
                $result = mysqli_query($conn, $query);

                while ($record = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                                    <td class="column">' . $record['roomName'] . '</td>
                                    <td class="column">' . $record['roomSpace'] . '</td>   
                                    
                              </tr>';
                }
                ?>
            </tbody>
        </table>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <?php
                require "manage/manageRooms/manageRoomsForm.php";
                ?>
            </div>
        </div>
    </div>

</body>

<script src="../scripts/modalWindow.js"></script>
<script src="../scripts/sort.js"></script>

</html>