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
                    <th class="column">Количество заявок <img src="{{ asset('images/sort.png') }}" class="Sort" />
                    </th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td class="column">
                            {{ $record->examSessionID }}
                        </td>
                        <td class="column">
                            {{ $record->requestsAmount }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitchingDiv')

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="/Manage/ExamSessionDelete">

                    @csrf

                    <label>Сессия</label>
                    <select name="examSessionID">
                        @foreach ($result as $record)
                            <option value="{{ $record->examSessionID }}">{{ $record->examSessionID }}</option>
                        @endforeach
                    </select>

                    <input type="submit" value="Удалить (Не рекомендуется!)" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/ExamSessionChangeCurrent">

                    @csrf

                    <label>Текущая сессия {{ $currentExamSessionID }} Поменять на</label>
                    <select name="examSessionID">
                        @foreach ($result as $record)
                            <option value="{{ $record->examSessionID }}">ID: {{ $record->examSessionID }}</option>
                        @endforeach
                    </select>

                    <input type="submit" value="Поменять" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/ExamSessionInsert">

                    @csrf
                    <label>Добавить новую сессию</label>
                    <input type="submit" value="Добавить" class="button-blue">
                </form>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('scripts/modalWindow.js') }}"></script>
<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
