<!DOCTYPE html>

<html>

<?php
require "../privileges/viewer.php";

if (isset($_GET['status'])) {
    if ($_GET['status'] == "approved") {
        $where = " WHERE isApproved = 1 OR isApproved = 2 ";

        $_SESSION['statusType'] = "approved";
        $title = "Одобренные заявки";
    } else if ($_GET['status'] == "rejected") {
        $where = " WHERE isApproved = 5 ";

        $_SESSION['statusType'] = "rejected";
        $title = "Отклонённые заявки";
    } else {
        $where = " WHERE isApproved = 0 ";

        $_SESSION['statusType'] = "new";
        $title = "Новые заявки";
    }
} else {
    $where = " WHERE isApproved = 0 ";

    $_SESSION['statusType'] = "new";
    $title = "Новые заявки";
}
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $where .= " $search ";
}
?>

<head>
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/employeeFandT.css">
    <link rel="stylesheet" href="../css/betterTable.css">
</head>

<?php
require "../db_conn.php";
require "topBottom/navBar.php";
require "topBottom/footer.html";
require "../pageSwitching/pageSwitchingGet.php";
?>

<body>
    <div class="main-body">
        <?php
        require "../pageSwitching/pageSwitchingDiv.php";
        ?>
        <table class="tableE">
            <thead class="tableE-head">
                <tr>
                    <th class="columnE">ID</th>
                    <th class="columnE">ФИО </th>
                    <th class="columnE">ID теста / Институт / Специальность / Курс / Отделение / Дисциплина</th>
                    <th class="columnE">Почта / Телефон</th>
                    <th class="columnE">Причина </th>
                    <th class="columnE">Подтверждающий документ</th>
                    <?php
                    if (($_SESSION['userPrivilege'] == 'Admin' || $_SESSION['userPrivilege'] == 'Support')) {
                        echo '<th class="columnE">Решение</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody class="tableE-body">
                <?php
                $query = "SELECT requestID, fullName, idOfTest, faculty, speciality, course, department, `subject`, mail, phoneNumber, reason, isApproved FROM requests $where ORDER BY requestID LIMIT $offSet,$perPage";
                $result = mysqli_query($conn, $query);

                $greyRow = false;
                while ($record = mysqli_fetch_assoc($result)) {
                    if ($greyRow) {
                        $classGrey = "-grey";
                    } else {
                        $classGrey = "";
                    }
                    $greyRow = !$greyRow;

                    echo '<tr>
                        <td class="columnE"><div class="columnText">' . $record['requestID'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record['fullName'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record['idOfTest'] . ' / 
                            ' . $record['faculty'] . ' /
                            ' . $record['speciality'] . ' /
                            ' . $record['course'] . ' / 
                            ' . $record['department'] . ' /
                            ' . $record['subject'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record['mail'] . ' /<br>' . $record['phoneNumber'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record['reason'] . '</div></td>
                        <td class="columnE">
                            <input onclick="goToImage(' . $record['requestID'] . ')" type="button" value="Перейти к файлу" class="calendar-button' . $classGrey . '">
                        </td>';
                    if (($_SESSION['userPrivilege'] == 'Admin' || $_SESSION['userPrivilege'] == 'Support')) {
                        if ($_SESSION['statusType'] == "new") {
                            echo '<td class="columnE">
                            <input onclick="setisApproved(' . $record['requestID'] . ', 1)" type="button" value="✓" class="calendar-button' . $classGrey . '-green-to-hover">
                            <input onclick="setisApproved(' . $record['requestID'] . ', 0)" type="button" value="X" class="calendar-button' . $classGrey . '-red-to-hover">';
                        } else if ($_SESSION['statusType'] == "approved") {
                            echo '<td class="columnE">
                            <input onclick="setisApproved(' . $record['requestID'] . ', 0)" type="button" value="X" class="calendar-button' . $classGrey . '-red-to-hover">';
                        } else if ($_SESSION['statusType'] == "rejected") {
                            echo '<td class="columnE">
                            <input onclick="setisApproved(' . $record['requestID'] . ', 1)" type="button" value="✓" class="calendar-button' . $classGrey . '-green-to-hover">';
                        }
                        echo '</td>';
                    }
                    echo '
                    </tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
        require "../pageSwitching/pageSwitchingDiv.php";
        ?>
        <form action="excelExport.php" method="POST" class="excel-download-form">
            <input type="hidden" name="statusType" value=<?php echo $_SESSION['statusType'] ?> />
            <input type="hidden" name="offSet" value="<?php echo $offSet ?>" />
            <input type="hidden" name="perPage" value="<?php echo $perPage ?>" />
            <input type="submit" value="Скачать эту страницу" class="button-blue">
        </form>
        <form action="excelExport.php" method="POST" class="excel-download-form">
            <input type="hidden" name="statusType" value=<?php echo $_SESSION['statusType'] ?> />
            <input type="submit" value="Скачать все страницы" class="button-blue">
        </form>
    </div>
</body>

<script src="../scripts/sort.js"></script>
<?php
if (($_SESSION['userPrivilege'] == 'Admin' || $_SESSION['userPrivilege'] == 'Support')) {
    echo '<script src="../scripts/setisApproved.js"></script>';
}
?>
<script src="../scripts/goToImage.js"></script>

</html>