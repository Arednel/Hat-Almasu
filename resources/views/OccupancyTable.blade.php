<!DOCTYPE html>

<html>

<head>
    <title>Наполненность</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/employeeFandT.css') }}">
    <link rel="stylesheet" href="{{ asset('css/betterTable.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')

<body>
    <div class="main-body">
        <table class="tableE">
            <thead class="tableE-head">
                <tr>
                    <th class="columnE">ID</th>
                    <th class="columnE">ФИО</th>
                    <th class="columnE">ID теста</th>
                    <th class="columnE">Отделение</th>
                    <th class="columnE">Институт / Специальность / Курс / Дисциплина</th>
                    <th class="columnE">Почта / Телефон</th>
                    <th class="columnE">Причина</th>
                    <th class="columnE">Вид Экзамена</th>
                    <th class="columnE">Подтверждающий документ</th>
                </tr>
            </thead>
            <tbody class="tableE-body">
                @php
                    $greyRow = false;
                @endphp

                @foreach ($result as $record)
                    <tr>
                        <td class="columnE">{{ $record->requestID }} </td>
                        <td class="columnE">{{ $record->fullName }}</td>
                        <td class="columnE">{{ $record->idOfTest }}</td>
                        <td class="columnE">{{ $record->department }}</td>
                        <td class="columnE">{{ $record->faculty }} /
                            {{ $record->speciality }} /
                            {{ $record->course }} /
                            {{ $record->subject }}
                        </td>
                        <td class="columnE">
                            {{ $record->mail }} /
                            {{ $record->phoneNumber }}
                        </td>
                        <td class="columnE">{{ $record->reason }}</td>
                        <td class="columnE"> {{ $record->examType }}</td>
                        <td class="columnE">
                            <button type="button" target="_blank"
                                onclick="window.open('/Request/Image/{{ $record->requestID }}')"
                                class="table-approval">
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
