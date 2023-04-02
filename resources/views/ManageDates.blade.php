<!DOCTYPE html>

<html>

<head>
    <title>Доступные даты</title>

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
                    <th class="column">Дата <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                    <th class="column">С / До <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                    <th class="column">Онлайн <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                    <th class="column">ID сессии <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td class="column">
                            {{ $record->date }}
                        </td>
                        <td class="column">
                            С {{ $record->startHour }}:00 до {{ $record->endHour }}:00
                        </td>
                        @if ($record->isOnline)
                            <td class="column">✓</td>
                        @else
                            <td class="column">X</td>
                        @endif
                        <td class="column">
                            {{ $record->examSessionID }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitchingDiv')

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="/Manage/DateInsert">

                    @csrf

                    <label>Дата</label>
                    @php
                        $tomorrow = date('Y-m-d', strtotime('+1 days'));
                        $yearLate = date('Y-m-d', strtotime('+1 year'));
                    @endphp
                    <input type="date" name="date" value="{{ $tomorrow }}" min="{{ $tomorrow }}"
                        max="{{ $yearLate }}">

                    <label>С</label>
                    <select name="startHour">
                        @for ($i = 8; $i < 20; $i++)
                            <option value="{{ $i }}">{{ $i }}:00</option>
                        @endfor
                    </select>
                    <label>До</label>
                    <select name="endHour">
                        @for ($i = 9; $i < 21; $i++)
                            <option value="{{ $i }}">{{ $i }}:00</option>
                        @endfor
                    </select>

                    <label>Онлайн</label>
                    <input type="checkbox" name="isOnline" value="1">

                    <input type="submit" value="Добавить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/DateDelete">

                    @csrf

                    <label>Дата</label>
                    <select name="date">
                        @foreach ($result as $record)
                            <option value="{{ $record->date }}">{{ $record->date }}</option>
                        @endforeach
                    </select>

                    <input type="submit" value="Удалить" class="button-blue">
                </form>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('scripts/modalWindow.js') }}"></script>
<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
