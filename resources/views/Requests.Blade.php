<!DOCTYPE html>

<html>

<head>
    <title>{{ $requestsTitle }}</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/employeeFandT.css') }}">
    <link rel="stylesheet" href="{{ asset('css/betterTable.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')

<body>
    <div class="main-body">

        @include ('/Components/pageSwitchingDiv')

        <table class="tableE">
            <thead class="tableE-head">
                <tr>
                    <th class="columnE">ID</th>
                    <th class="columnE">ФИО </th>
                    <th class="columnE">ID теста </th>
                    <th class="columnE">Отделение </th>
                    <th class="columnE">Институт / Специальность / Курс / Дисциплина</th>
                    <th class="columnE">Почта / Телефон</th>
                    <th class="columnE">Причина </th>
                    <th class="columnE">Вид Экзамена </th>
                    <th class="columnE">Подтверждающий документ</th>
                    @if (in_array(Session::get('userPrivilege'), ['Admin', 'Support']))
                        <th class="columnE">Решение</th>
                    @endif
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
                                {{ $record->idOfTest }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->department }}
                            </div>
                        </td>
                        <td class="columnE">
                            <div class="columnText">
                                {{ $record->faculty }} /
                                {{ $record->speciality }} /
                                {{ $record->course }} /
                                {{ $record->subject }}
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
                            <div class="columnText">
                                {{ $record->examType }}
                            </div>
                        </td>
                        <td class="columnE">
                            <button type="button" target="_blank"
                                onclick="window.open('/Requests/Image/{{ $record->requestID }}')"
                                class="table-approval{{ $classGrey }}">
                                Перейти к файлу
                            </button>
                        </td>
                        @if (in_array(Session::get('userPrivilege'), ['Admin', 'Support']))
                            <td class="columnE">
                                @if (in_array($statusType, ['new', 'rejected']))
                                    <button type="button" target="_blank"
                                        onclick="window.location=('/Requests/ChangeStatus/{{ $record->requestID }}/1')"
                                        class="table-approval{{ $classGrey }}-green-to-hover">
                                        ✓
                                    </button>
                                @endif
                                @if (in_array($statusType, ['new', 'approved']))
                                    <button type="button" target="_blank"
                                        onclick="window.location=('/Requests/ChangeStatus/{{ $record->requestID }}/3')"
                                        class="table-approval{{ $classGrey }}-red-to-hover">
                                        X
                                    </button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>

        @include ('/Components/pageSwitchingDiv')

        <button type="button" target="_blank"
            onclick="window.location=('/Requests/ExcelExport/{{ $statusType }}/{{ $currentPage }}')"
            class="button-blue-excel">
            Скачать эту страницу
        </button>
        <br>
        <button type="button" target="_blank"
            onclick="window.location=('/Requests/ExcelExportAll/{{ $statusType }}')" class="button-blue-excel">
            Скачать все страницы
        </button>
        <br>
    </div>
</body>

<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
