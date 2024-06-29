<link rel="stylesheet" href="{{ asset('css/NavBar.css') }}" />

<header class="nav-bar">
    <a href="/"><img src="{{ asset('images/logo.png') }}" class="topLogo"></a>
    <div class="nav-bar-center">
        <a href="/SupportTicketStatus">{!! __('Статус заявки') !!}</a>
        <a href="/SupportTicketNew" class="red">{!! __('Подать заявку') !!}</a>
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
</header>
