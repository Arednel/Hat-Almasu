<link rel="stylesheet" href="../css/navBar.css">
content
<div class="nav-bar">
    <a href="index.php"><img src="../images/logo.png" class="topLogo"></a>
    <div class="nav-bar-center">
        <a href="verifyRequest.php">Қолданба күйі</a>&nbsp
        <a href="booking.php" class="red">Өтінім беру</a>
        <?php
        if (isset($_SESSION['userID'])) {
            if ($_SESSION['userPrivilege'] == 'Admin') {
                echo '<div class="DropDown">
                      <button class="dropbtn">Басқару</button>
                            <div class="DropDown-content">
                                <a href="manageDates.php">Қол жетімді күн</a>
                                <a href="manageRooms.php">Қол жетімді аудитория</a>                             
                                <a href="manageUsers.php">Қолданушылар</a>
                            </div>
                      </div>
                      &nbsp<a href="occupancyDate.php">Толтыру</a>&nbsp';
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
                      <button class="dropbtn">Өтінім</button>
                            <div class="DropDown-content">
                                <a href="requests.php?status=new"">Жаңа</a>
                                <a href="requests.php?status=approved">Бекітілген</a>
                                <a href="requests.php?status=rejected">Қабылданбады</a>   
                            </div>
                </div>';
            }
            echo
            '&nbsp<a href="logout.php"> Шығу </a>';
        }
        ?>
    </div>
    <div class="nav-bar-right">
        <img src="../images/language.png" class="topLanguage">
        <div class="DropDown">
            <button class="dropbtn">Тіл/Kz</button>
            <div class="DropDown-content">
                <a href="/kz/">Қазақ тілі</a>
                <a href="/ru/">Орыс тілі</a>
            </div>
        </div>
    </div>
</div>