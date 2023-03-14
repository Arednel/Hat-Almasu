<!DOCTYPE html>

<html>

<head>
    <title>Главная страница</title>

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

            <h1>Сайт для подачи заявок на пересдачу</h1>
            <h2>Сайт разработан для подачи онлайн-заявок
                <br>на пересдачу для обучающихся.
            </h2>
            <br>
            <img src="../images/1.jpg" class="imgOne">
        </div>

        <div class="secondDiv">
            <h3><b>Что такое Retake.kaznpu.kz?</b></h3>
            <div class="secondDivLeft">
                <img src="../images/2.jpg" class="imgTwo">
                <br>
            </div>
            <div class="secondDivRight">
                <p class="secondDivRightTextFirst">
                    Функция подачи заявок
                </p>
                <p class="secondDivRightTextSecond">
                    Сайт даёт возможность подачи заявок<br>
                    на пересдачу и последующего выбора<br>
                    даты и времени пересдачи.
                </p>
            </div>
        </div>

        <div class="thirdDiv">
            <h4>FAQ - Часто задаваемые вопросы</h4>
            <div class="help">
                <br>
                <h3>Как подать заявку на пересдачу?</h3>
                <ol>
                    <li>Для подачи заявки на пересдачу, нажмите <b>Подать заявку</b>.</li>
                    <li>После, заполните форму и нажмите <b>Отправить</b>.</li>
                </ol>
                <hr>
                <h3>Что дальше?</h3>
                <ol>
                    <li>Подождите, пока рассмотрят заявку</li>
                    <li>Нажмите на сайте <b>Статус заявки</b> и укажите номер заявки и почту, указанную в заявке.</li>
                    <li>Вам будет сообщён статус заявки.</li>
                    <li>Если заявка одобрена, выберите удобный для вас день пересдачи (доступные дни для пересдачи выделены зелёным).</li>
                    <li>После выберите удобное для вас время и аудиторию (Если пересдача онлайн, то выбрать нужно только день).</li>
                    <li>Готово!</li>
                </ol>
                <br>
            </div>
            <br>
        </div>
    </div>
</body>

</html>