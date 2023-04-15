<!DOCTYPE html>

<html>

<head>
    <title>Сессии</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="{{ asset('css/StandardTable.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Modal.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')
@include('/Components/tableAddNew')

<body>
    <div class="main-body">

        @include ('/Components/pageSwitching')

        <table class="table">
            <thead class="table-head">
                <tr>
                    <th>ID</th>
                    <th>Заявки</th>
                    <th>Даты для пересдачи</th>
                    <th>Аудитории</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td>{{ $record->examSessionID }}</td>
                        <td>{{ $record->requestsAmount }}</td>
                        <td>{{ $record->datesAmount }}</td>
                        <td>{{ $record->roomsAmount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitching')

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
                    <input type="submit" value="Добавить новую" class="button-blue">
                </form>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('scripts/modalWindow.js') }}"></script>
<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
