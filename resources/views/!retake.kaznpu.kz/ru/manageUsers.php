<!DOCTYPE html>

<html>

<head>
    <title>Список пользователей</title>
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
require "manage/manageUsers/manageUsersLogic.php";
?>

<body>
    <div class="main-body">
        <table class="table">
            <thead class="table-head">
                <tr>
                    <th class="column">Логин <img src="../images/sort.png" class="Sort" /></th>
                    <th class="column">Пароль <img src="../images/sort.png" class="Sort" /></th>
                    <th class="column">Разрешения <img src="../images/sort.png" class="Sort" />
                    <th class="column">ID пользователя <img src="../images/sort.png" class="Sort" />
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                $query = 'SELECT * FROM users ORDER BY userID';
                $result = mysqli_query($conn, $query);

                while ($record = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                                    <td class="column">' . $record['userName'] . '</td>
                                    <td class="column">' . $record['userPassword'] . '</td>
                                    <td class="column">' . $record['userPrivilege'] . '</td>   
                                    <td class="column">' . $record['userID'] . '</td>                                    
                              </tr>';
                }
                ?>
            </tbody>
        </table>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <?php
                require "manage/manageUsers/manageUsersForm.html";
                ?>
            </div>
        </div>

    </div>
</body>

<script src="../scripts/modalWindow.js"></script>
<script src="../scripts/sort.js"></script>

</html>