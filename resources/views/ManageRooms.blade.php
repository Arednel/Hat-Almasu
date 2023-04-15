<!DOCTYPE html>

<html>

<head>
    <title>Аудитории</title>

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
                    <th>Название Аудитории</th>
                    <th>Количество мест</th>
                    <th>ID сессии</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td>{{ $record->roomName }}</td>
                        <td>{{ $record->roomSpace }}</td>
                        <td>{{ $record->examSessionID }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitching')

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
                                {{ $record->roomName }} &#40 {{ $record->roomSpace }} мест &#41 , &#40
                                {{ $record->examSessionID }} сессия &#41
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
                            <option value="{{ $record->roomID }}">{{ $record->roomName }} &#40
                                {{ $record->roomSpace }} мест &#41 , &#40
                                {{ $record->examSessionID }} сессия &#41</option>
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
