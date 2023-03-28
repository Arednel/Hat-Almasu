<!DOCTYPE html>

<html>

<head>
    <title>Список аудиторий</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/employeeFandT.css') }}">
    <link rel="stylesheet" href="{{ asset('css/betterTableManage.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')
@include('/Components/tableAddNew')

<body>
    <div class="main-body">

        @include ('/Components/pageSwitchingDiv')

        <table class="table">
            <thead class="table-head">
                <tr>
                    <th class="column">ID сессии <img src="{{ asset('images/sort.png') }}" class="Sort" />
                    </th>
                    <th class="column">Начало сессии <img src="{{ asset('images/sort.png') }}" class="Sort" />
                    </th>
                    <th class="column">Конец сесии <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td class="column">
                            {{ $record->sessionID }}
                        </td>
                        <td class="column">
                            {{ $record->sessionStart }}
                        </td>
                        <td class="column">
                            {{ $record->sessionEnd }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitchingDiv')

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="/Manage/SessionInsert">

                    @csrf

                    @php
                        $tomorrow = date('Y-m-d', strtotime('+1 days'));
                        $tomorrowPlusOne = date('Y-m-d', strtotime('+2 days'));
                        $yearLate = date('Y-m-d', strtotime('+1 year'));
                    @endphp

                    <label>Начало сессии</label>
                    <input type="date" name="sessionStart" value="{{ $tomorrow }}" min="{{ $tomorrow }}"
                        max="{{ $yearLate }}">
                    <label>Конец сессии</label>
                    <input type="date" name="sessionEnd" value="{{ $tomorrowPlusOne }}"
                        min="{{ $tomorrowPlusOne }}" max="{{ $yearLate }}">

                    <input type="submit" value="Добавить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/SessionDelete">

                    @csrf

                    <label>Сессия</label>
                    <select name="sessionID">
                        @foreach ($result as $record)
                            <option value="{{ $record->sessionID }}">С {{ $record->sessionStart }} до
                                {{ $record->sessionEnd }}</option>
                        @endforeach
                    </select>

                    <input type="submit" value="Удалить (Не рекомендуется!)" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/SessionChangeCurrent">

                    @csrf

                    <label>Текущая сессия {{ $currentSessionID }} Поменять на</label>
                    <select name="sessionID">
                        @foreach ($result as $record)
                            <option value="{{ $record->sessionID }}">ID: {{ $record->sessionID }}</option>
                        @endforeach
                    </select>

                    <input type="submit" value="Поменять" class="button-blue">
                </form>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('scripts/modalWindow.js') }}"></script>
<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
