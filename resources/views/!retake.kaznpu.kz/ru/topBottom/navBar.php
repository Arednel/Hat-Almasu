<link rel="stylesheet" href="../css/navBar.css">

<div class="nav-bar">
    <a href="index.php"><img src="../images/logo.png" class="topLogo"></a>
    <div class="nav-bar-center">
        <a href="verifyRequest.php">Статус заявки</a>&nbsp
        <a href="booking.php" class="red">Подать заявку</a>
        <?php
        if (isset($_SESSION['userID'])) {
            if ($_SESSION['userPrivilege'] == 'Admin') {
                echo '<div class="DropDown">
                      <button class="dropbtn">Управление</button>
                            <div class="DropDown-content">
                                <a href="manageDates.php">Доступными датами</a>
                                <a href="manageRooms.php">Доступными аудиториями</a>                              
                                <a href="manageUsers.php">Пользователями</a>
                            </div>
                      </div>
                      &nbsp<a href="occupancyDate.php">Заполненность</a>&nbsp';
            }
            if (
                $_SESSION['userPrivilege'] == 'Admin' ||
                $_SESSION['userPrivilege'] == 'Support' ||
                $_SESSION['userPrivilege'] == 'Viewer'
            ) {
                echo '<style>';
                include "../css/adminS.css";
                echo '</style>';
                echo
                '<div class="DropDown">
                      <button class="dropbtn">Заявки</button>
                            <div class="DropDown-content">
                                <a href="requests.php?status=new">Новые</a>
                                <a href="requests.php?status=approved">Одобренные</a>
                                <a href="requests.php?status=rejected">Отклонённые</a>                                
                            </div>
                </div>';
            }
            echo
            '&nbsp<a href="logout.php"> Выйти </a>';
        }
        ?>
    </div>
    <div class="nav-bar-right">
        <img src="../images/language.png" class="topLanguage">
        <div class="DropDown">
            <button class="dropbtn">Язык/Ru</button>
            <div class="DropDown-content">
                <a href="/kz/">Казахский</a>
                <a href="/ru/">Русский</a>
            </div>
        </div>
    </div>
</div>