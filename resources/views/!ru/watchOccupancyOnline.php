<!DOCTYPE html>

<html>

<head>
    <title>Наполненность</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/employeeFandT.css">
    <link rel="stylesheet" href="../css/betterTable.css">
</head>

<?php
require "../db_conn.php";
require "../privileges/admin.php";
require "topBottom/navBar.php";
require "topBottom/footer.html";
require "../pageSwitching/pageSwitchingGet.php";

$chosenDate = str_replace('"', '', $_SESSION['chosenDate']);
$_SESSION['statusType'] = "watchOccupancyOnline";
?>

<body>
    <div class="main-body">
        <?php
        require "../pageSwitching/pageSwitchingDiv.php";
        ?>
        <table class="tableE">
            <thead class="tableE-head">
                <tr>
                    <th class="column" colspan="100%">
                        <?php
                        echo $chosenDate . ' / Онлайн';
                        ?>
                    </th>
                </tr>
            </thead>
            <thead class="tableE-head">
                <tr>
                    <th class="columnE">ID</th>
                    <th class="columnE">ФИО </th>
                    <th class="columnE">ID теста / Институт / Специальность / Курс / Отделение / Дисциплина</th>
                    <th class="columnE">Почта / Телефон</th>
                    <th class="columnE">Причина </th>
                    <th class="columnE">Подтверждающий документ</th>
                </tr>
            </thead>
            <tbody class="tableE-body">
                <?php
                $query = "SELECT requestID FROM bookingrecords WHERE bookingDate = '$chosenDate' LIMIT $offSet,$perPage";
                $result1 = mysqli_query($conn, $query);
                while ($record1 = mysqli_fetch_assoc($result1)) {
                    $requestID = $record1['requestID'];
                    $query = "SELECT requestID, fullName, idOfTest, faculty, speciality, course, department, `subject`, mail, phoneNumber, reason FROM requests WHERE requestID = $requestID ORDER BY requestID";
                    $result2 = mysqli_query($conn, $query);

                    $greyRow = false;
                    while ($record2 = mysqli_fetch_assoc($result2)) {
                        if ($greyRow) {
                            $classGrey = "-grey";
                        } else {
                            $classGrey = "";
                        }
                        $greyRow = !$greyRow;

                        echo '<tr>
                        <td class="columnE"><div class="columnText">' . $record2['requestID'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record2['fullName'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record2['idOfTest'] . ' / 
                            ' . $record2['faculty'] . ' /
                            ' . $record2['speciality'] . ' /
                            ' . $record2['course'] . ' / 
                            ' . $record2['department'] . ' /
                            ' . $record2['subject'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record2['mail'] . ' /<br>' . $record2['phoneNumber'] . '</div></td>
                        <td class="columnE"><div class="columnText">' . $record2['reason'] . '</div></td>
                        <td class="columnE">
                            <input onclick="goToImage(' . $record2['requestID'] . ')" type="button" value="Перейти к файлу" class="calendar-button' . $classGrey . '">
                        </td>
                    </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
        require "../pageSwitching/pageSwitchingDiv.php";
        ?>
    </div>
</body>

<script src="../scripts/sort.js"></script>
<script src="../scripts/goToImage.js"></script>

</html>