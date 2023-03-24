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
                    <th class="columnE">ФИО </th>
                    <th class="columnE">ID теста / Институт / Специальность / Курс / Отделение / Дисциплина</th>
                    <th class="columnE">Почта / Телефон</th>
                    <th class="columnE">Причина </th>
                    <th class="columnE">Подтверждающий документ</th>
                </tr>
            </thead>
            <tbody class="tableE-body">
                @php
                    $greyRow = false;
                @endphp

                @foreach ($result as $record)
                    {{-- fix that, it's awful --}}
                    @if ($greyRow)
                        @php
                            $classGrey = '-grey';
                        @endphp
                    @else
                        @php
                            $classGrey = '';
                        @endphp
                    @endif
                    @php
                        $greyRow = !$greyRow;
                    @endphp
                    {{-- fix that, it's awful --}}

                    <tr>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->requestID }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->fullName }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->idOfTest }} / {{ $record->faculty }} /
                                {{ $record->speciality }} /
                                {{ $record->course }} / {{ $record->department }} / {{ $record->subject }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->mail }}/<br>
                                {{ $record->phoneNumber }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->reason }}
                            </div>
                        </td>
                        <td class="columnE">
                            <button type="button" target="_blank"
                                onclick="window.open('/Requests/Image/{{ $record->requestID }}')"
                                class="calendar-button{{ $classGrey }}">
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
