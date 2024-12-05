<!DOCTYPE html>

<html>

<head>
    <title>{!! __('Главная страница') !!}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/Index.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')

<body>
    <div class="main-body">
        <div class="firstDiv">

            @if (isset($_GET['message']))
                <p class="message-green"> {{ $_GET['message'] }} </p>
            @endif
            @if (isset($_GET['messageokay']))
                <p class="message-grey"> {{ $_GET['messageokay'] }} </p>
            @endif
            @if (isset($_GET['error']))
                <p class="message-red"> {{ $_GET['error'] }} </p>
            @endif

            <h1>Hat Almasu</h1>
            <h2>{!! __('Сайт для подачи онлайн-заявок<br> при технических ошибках или для записи в общежитие') !!}
            </h2>
            <br>
            <img src="{{ asset('images/1.jpg') }}" class="imgOne">
        </div>

        <div class="secondDiv">
            <h3><b>{!! __('Что такое Hat Almasu?') !!}</b></h3>
            <div class="secondDivLeft">
                <img src="{{ asset('images/2.jpg') }}" class="imgTwo">
                <br><br>
            </div>
            <div class="secondDivRight">
                <p class="secondDivRightTextFirst">
                    {!! __('Функция подачи заявок') !!}
                </p>
                <p class="secondDivRightTextSecond">
                    {!! __('Сайт даёт возможность подачи заявок<br>при технических ошибках') !!}
                </p>
            </div>
        </div>

        <div class="thirdDiv">
            <div class="help">
                <h5 class="faq-heading">{!! __('FAQ - Часто задаваемые вопросы') !!}</h1>
                    <section class="faq-container">
                        <div>
                            <h6 class="faq-page">{!! __('Как подать заявку на пересдачу?') !!}</h1>
                                <div class="faq-body">
                                    <ol>
                                        <li>{!! __('Для подачи заявки на пересдачу, нажмите <b>Подать заявку</b>.') !!}</li>
                                        <li>{!! __('После, заполните форму и нажмите <b>Отправить</b>.') !!}</li>
                                    </ol>
                                </div>
                        </div>
                        <hr class="hr-line">
                        <div>
                            <h6 class="faq-page">{!! __('Что дальше?') !!}</h1>
                                <div class="faq-body">
                                    <ol>
                                        <li>{!! __('Подождите, пока рассмотрят заявку') !!}</li>
                                        <li>{!! __('Нажмите на сайте <b>Статус заявки</b> и укажите номер заявки и почту, указанную в заявке.') !!}</li>
                                        <li>{!! __('Вам будет сообщён статус заявки.') !!}</li>
                                        <li>{!! __('Готово!') !!}</li>
                                    </ol>
                                </div>
                        </div>
                    </section>
                    <br>
            </div>
        </div>

    </div>
</body>

<script src="{{ asset('scripts/faqPage.js') }}"></script>

<html>
