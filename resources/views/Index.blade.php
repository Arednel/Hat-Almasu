<!DOCTYPE html>

<html>

<head>
    <title>{!! __('Главная страница') !!}</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')

<body>
    <div class="main-body">
        <div class="firstDiv">

            @php
                if (isset($_GET['message'])) {
                    echo '<p class="message-green"> ' . $_GET['message'] . '</p>';
                }
                if (isset($_GET['messageokay'])) {
                    echo '<p class="message-grey"> ' . $_GET['messageokay'] . '</p>';
                }
                if (isset($_GET['error'])) {
                    echo '<p class="message-red"> ' . $_GET['error'] . '</p>';
                }
            @endphp

            <h1>Hat Almasu</h1>
            <h2>{!! __('Сайт разработан для подачи онлайн-заявок<br> на пересдачу для обучающихся.') !!}
            </h2>
            <br>
            <img src="{{ asset('images/1.jpg') }}" class="imgOne">
        </div>

        <div class="secondDiv">
            <h3><b>{!! __('Что такое Hat Almasu?') !!}</b></h3>
            <div class="secondDivLeft">
                <img src="{{ asset('images/2.jpg') }}" class="imgTwo">
                <br>
            </div>
            <div class="secondDivRight">
                <p class="secondDivRightTextFirst">
                    {!! __('Функция подачи заявок') !!}
                </p>
                <p class="secondDivRightTextSecond">
                    {!! __('Сайт даёт возможность подачи заявок<br>на пересдачу и последующего выбора<br>даты и времени пересдачи.') !!}
                </p>
            </div>
        </div>

        <div class="thirdDiv">
            <h4>{!! __('FAQ - Часто задаваемые вопросы') !!}</h4>
            <div class="help">
                <br>
                <h3>{!! __('Как подать заявку на пересдачу?') !!}</h3>
                <ol>
                    <li>{!! __('Для подачи заявки на пересдачу, нажмите <b>Подать заявку</b>.') !!}</li>
                    <li>{!! __('После, заполните форму и нажмите <b>Отправить</b>.') !!}</li>
                </ol>
                <hr>
                <h3>{!! __('Что дальше?') !!}</h3>
                <ol>
                    <li>{!! __('Подождите, пока рассмотрят заявку') !!}</li>
                    <li>{!! __('Нажмите на сайте <b>Статус заявки</b> и укажите номер заявки и почту, указанную в заявке.') !!}</li>
                    <li>{!! __('Вам будет сообщён статус заявки.') !!}</li>
                    <li>{!! __('Если заявка одобрена, выберите удобный для вас день пересдачи.') !!}</li>
                    <li>{!! __(
                        'После выберите удобное для вас аудиторию и время (Если пересдача онлайн, то выбрать нужно только день).',
                    ) !!}</li>
                    <li>{!! __('Готово!') !!}</li>
                </ol>
                <br>
            </div>
            <br>
        </div>
    </div>
</body>

<html>
