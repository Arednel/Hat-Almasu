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
                    <th class="column">Название Аудитории <img src="{{ asset('images/sort.png') }}" class="Sort" />
                    </th>
                    <th class="column">Количество мест <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td class="column">
                            {{ $record->roomName }}
                        </td>
                        <td class="column">
                            {{ $record->roomSpace }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitchingDiv')

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="/Manage/RoomInsert">

                    @csrf

                    <label>Название аудитории</label>
                    <input type="text" name="roomName" required />
                    <label>Количество мест</label>
                    <input type="number" name="roomSpace" max="500" required />

                    <input type="submit" value="Добавить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/RoomUpdate">

                    @csrf

                    <label>Название аудитории</label>
                    <input type="text" name="roomName" />
                    <label>Количество мест</label>
                    <input type="number" name="roomSpace" max="1000" />
                    <label>Аудитория</label>
                    <select name="roomID">
                        @foreach ($result as $record)
                            <option value="{{ $record->roomID }}">
                                {{ $record->roomName }} &#40 {{ $record->roomSpace }} &#41
                            </option>
                        @endforeach
                    </select>

                    <input type="submit" value="Изменить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/RoomDelete">

                    @csrf

                    <label>Аудитория</label>
                    <select name="roomID">
                        @foreach ($result as $record)
                            <option value="{{ $record->roomID }}">{{ $record->roomName }}</option>
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
