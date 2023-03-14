<!DOCTYPE html>

<html>

<head>
    <title>Басты бет</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/index.css">
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../db_conn.php";
require "topBottom/navBar.php";
require "topBottom/footer.html";
?>

<body>
    <div class="main-body">
        <div class="firstDiv">

            <?php
            if (isset($_GET['message'])) {
                echo '<p class="message-green"> ' . $_GET['message'] . '</p>';
            }
            if (isset($_GET['messageokay'])) {
                echo '<p class="message-grey"> ' . $_GET['messageokay'] . '</p>';
            }
            if (isset($_GET['error'])) {
                echo '<p class="message-red"> ' . $_GET['error'] . '</p>';
            }
            ?>

            <h1>Сайт қайта тапсыру өтінімдері үшін </h1>
            <h2>Сайт білім алушыларға қайта тапсыруға онлайн-өтінім<br>
                беру үшін әзірленген.
            </h2>
            <br>
            <img src="../images/1.jpg" class="imgOne">
        </div>

        <div class="secondDiv">
            <h3><b>Retake.kaznpu.kz деген не?</b></h3>
            <div class="secondDivLeft">
                <img src="../images/2.jpg" class="imgTwo">
                <br>
            </div>
            <div class="secondDivRight">
                <p class="secondDivRightTextFirst">
                    Өтініш беру функциясы
                </p>
                <p class="secondDivRightTextSecond">
                    Сайт өтінім беруге мүмкіндік береді<br>
                    қайта тапсыру және кейінгі таңдау үшін<br>
                    қайта тапсыру күні мен уақыты.
                </p>
            </div>
        </div>

        <div class="thirdDiv">
            <h4>FAQ - Жиі қойылатын сұрақтар</h4>
            <div class="help">
                <br>
                <h3>Қайта тапсыруға өтінімді қалай берсе болады?</h3>
                <ol>
                    <li>Қайта тапсыруға өтінімді беру үшін <b>Өтінім беру</b> түймесін басыңыз.</li>
                    <li>Келесі, форманы толтырып <b>Жіберу</b> түймесін басыңыз.</li>
                </ol>
                <hr>
                <h3>Келесі кезекте?</h3>
                <ol>
                    <li>Жіберілген өтінімнің мәртебесі сіз көрсеткен поштада хабарланады.</li>
                    <li>Түймесін басың сайттағы <b>Қолданба күйі</b> және өтініште көрсетілген өтініш пен поштаның нөмірін көрсетіңіз.</li>
                    <li>Сізге өтінімнің күйі туралы хабарланады</li>
                    <li>Өтінім мақұлданса, өқолайлы қайта тапсыру күнін таңдаңыз (бос күндер жасыл түспен берілген).</li>
                    <li>Келесі өзіңізге қолайлы уақыт пен аудиторияны таңдаңыз (Қайта қабылдау онлайн болса, онда тек күнді таңдау керек).</li>
                    <li>Дайын!</li>
                </ol>
                <br>
            </div>
            <br>
        </div>
    </div>
</body>

</html>