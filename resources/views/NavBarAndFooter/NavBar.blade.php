<link rel="stylesheet" href="{{ asset('css/NavBar.css') }}" />

<div class="nav-bar">
    <a href="/"><img src="{{ asset('images/logo.png') }}" class="topLogo"></a>
    <div class="nav-bar-center">
        <a href="VerifyRequest">Статус заявки</a>&nbsp
        <a href="Booking" class="red">Подать заявку</a>
        @php
            // if (isset($_SESSION['userID'])) {
            //     if ($_SESSION['userPrivilege'] == 'Admin') {
            //         echo '<div class="DropDown">
//       <button class="dropbtn">Управление</button>
//             <div class="DropDown-content">
//                 <a href="manageDates">Доступными датами</a>
//                 <a href="manageRooms">Доступными аудиториями</a>
//                 <a href="manageUsers">Пользователями</a>
//             </div>
//       </div>
//       &nbsp<a href="occupancyDate">Заполненность</a>&nbsp';
            //     }
            //     if ($_SESSION['userPrivilege'] == 'Admin' || $_SESSION['userPrivilege'] == 'Support' || $_SESSION['userPrivilege'] == 'Viewer') {
            //         echo '<style>';
            //         include '../css/adminS.css';
            //         echo '</style>';
            //         echo '<div class="DropDown">
//       <button class="dropbtn">Заявки</button>
//             <div class="DropDown-content">
//                 <a href="requests?status=new">Новые</a>
//                 <a href="requests?status=approved">Одобренные</a>
//                 <a href="requests?status=rejected">Отклонённые</a>
//             </div>
// </div>';
            //     }
            //     echo '&nbsp<a href="logout"> Выйти </a>';
            // }
        @endphp
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
