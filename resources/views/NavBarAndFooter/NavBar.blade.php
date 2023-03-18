<link rel="stylesheet" href="{{ asset('css/NavBar.css') }}" />

<div class="nav-bar">
    <a href="/"><img src="{{ asset('images/logo.png') }}" class="topLogo"></a>
    <div class="nav-bar-center">
        <a href="/VerifyRequest">Статус заявки</a>&nbsp
        <a href="/Booking" class="red">Подать заявку</a>

        @if (Session::get('userID'))
            <link rel="stylesheet" href="{{ asset('css/adminS.css') }}">

            <div class="DropDown">
                <button class="dropbtn">Управление</button>
                <div class="DropDown-content">
                    <a href="/manageDates">Доступными датами</a>
                    <a href="/manageRooms">Доступными аудиториями</a>
                    <a href="/manageUsers">Пользователями</a>
                </div>
            </div>
            &nbsp<a href="/occupancyDate">Заполненность</a>&nbsp
            <div class="DropDown">
                <button class="dropbtn">Заявки</button>
                <div class="DropDown-content">
                    <a href="/Requests/New">Новые</a>
                    <a href="/Requests/Approved">Одобренные</a>
                    <a href="/Requests/Rejected">Отклонённые</a>
                </div>
            </div>&nbsp<a href="/Logout"> Выйти </a>
        @endif
    </div>
    <div class="nav-bar-right">
        <img src="{{ asset('images/language.png') }}" class="topLanguage">
        <div class="DropDown">
            <button class="dropbtn">Язык/Ru</button>
            <div class="DropDown-content">
                {{-- <a href="/kz/">Казахский</a>
                <a href="/ru/">Русский</a> --}}
            </div>
        </div>
    </div>
</div>
