<!DOCTYPE html>

<html>

<head>
    <title>Наполненность</title>

    <link rel="stylesheet" href="{{ asset('css/StandardTable.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')

<body>
    <div class="main-body">
        <table>
            <colgroup>
                <col span="4" style="width: 4%" />
                <col span="8" />
                <col style="width: 6%" />
            </colgroup>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID теста</th>
                    <th>Отделение</th>
                    <th>Курс</th>
                    <th>ФИО</th>
                    <th>Институт</th>
                    <th>Специальность</th>
                    <th>Дисциплина</th>
                    <th>Почта</th>
                    <th>Телефон</th>
                    <th>Причина</th>
                    <th>Вид Экзамена</th>
                    <th>Файл</th>
            </thead>
            <tbody>
                @foreach ($result as $record)
                    <tr>
                        <td>{{ $record->requestID }} </td>
                        <td>{{ $record->idOfTest }} </td>
                        <td>{{ $record->department }} </td>
                        <td>{{ $record->course }} </td>
                        <td>{{ $record->fullName }} </td>
                        <td>{{ $record->faculty }} </td>
                        <td>{{ $record->speciality }} </td>
                        <td>{{ $record->subject }} </td>
                        <td>{{ $record->mail }} </td>
                        <td>{{ $record->phoneNumber }} </td>
                        <td>{{ $record->reason }} </td>
                        <td>{{ $record->examType }} </td>
                        <td>
                            <button type="button" target="_blank"
                                onclick="window.open('/Requests/Image/{{ $record->requestID }}')"
                                class="button-image-view">
                                Перейти к файлу
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
