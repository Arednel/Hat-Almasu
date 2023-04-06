<link rel="stylesheet" href="{{ asset('css/NavBar.css') }}" />

<div class="nav-bar">
    <a href="/"><img src="{{ asset('images/logo.png') }}" class="topLogo"></a>
    <div class="nav-bar-center">
        <a href="/Register">{!! __('Статус заявки') !!}</a>&nbsp
        <a href="/RequestNew" class="red">{!! __('Подать заявку') !!}</a>

        @if (Session::get('userID'))
            <link rel="stylesheet" href="{{ asset('css/adminS.css') }}">

            <div class="DropDown">
                <button class="dropbtn">{!! __('Управление') !!}</button>
                <div class="DropDown-content">
                    <a href="/Manage/Dates/0">{!! __('Доступными датами') !!}</a>
                    <a href="/Manage/Rooms/0">{!! __('Доступными аудиториями') !!}</a>
                    <a href="/Manage/Users/0">{!! __('Пользователями') !!}</a>
                    <a href="/Manage/ExamSessions/0">{!! __('Сессиями') !!}</a>
                </div>
            </div>
            &nbsp<a href="/Occupancy/Date">{!! __('Заполненность') !!}</a>&nbsp
            <div class="DropDown">
                <button class="dropbtn">{!! __('Заявки') !!}</button>
                <div class="DropDown-content">
                    <a href="/Requests/View/new/0">{!! __('Новые') !!}</a>
                    <a href="/Requests/View/approved/0">{!! __('Одобренные') !!}</a>
                    <a href="/Requests/View/rejected/0">{!! __('Отклонённые') !!}</a>
                </div>
            </div>&nbsp<a href="/Logout"> {!! __('Выйти') !!} </a>
        @endif
    </div>
    <div class="nav-bar-right">
        <img src="{{ asset('images/language.png') }}" class="topLanguage">
        <div class="DropDown">
            <button class="dropbtn">{!! __('Язык/Ru') !!}</button>
            <div class="DropDown-content">
                <a href="/Language/kz">{!! __('Казахский') !!}</a>
                <a href="/Language/ru">{!! __('Русский') !!}</a>
            </div>
        </div>
    </div>
</div>
