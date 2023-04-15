<!DOCTYPE html>

<html>

<head>
    <title>{{ $requestsTitle }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/StandardTable.css') }}">
</head>

@include('/Components/navBar')
@include('/Components/footer')

<body>
    <div class="main-body">

        @include ('/Components/pageSwitching')
        @include ('/Components/search')

        <table>
            <colgroup>
                <col span="4" style="width: 4%" />
                <col span="8" />
                <col style="width: 6%" />
                @can('support')
                    <col style="width: 4%" />
                @endcan
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
                    @can('support')
                        <th>Решение</th>
                    @endcan
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
                                Перейти
                            </button>
                        </td>
                        @can('support')
                            <td>
                                @if (in_array($statusType, ['new', 'rejected']))
                                    <button type="button" target="_blank"
                                        onclick="window.location=('/Requests/ChangeStatus/{{ $record->requestID }}/1')"
                                        class="button-approve">
                                        ✓
                                    </button>
                                @endif
                                @if (in_array($statusType, ['new', 'approved']))
                                    <button type="button" target="_blank"
                                        onclick="window.location=('/Requests/ChangeStatus/{{ $record->requestID }}/3')"
                                        class="button-reject">
                                        X
                                    </button>
                                @endif
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitching')
        @include ('/Components/excelExport')

    </div>
</body>

<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
