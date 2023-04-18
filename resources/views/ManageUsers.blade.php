<!DOCTYPE html>

<html>

<head>
    <title>Пользователи</title>

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
                    <th>Логин</th>
                    <th>Уровень доступа</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td>{{ $record->username }}</td>
                        <td>{{ $record->user_privilege }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitching')

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="/Manage/UserInsert">

                    @csrf

                    <label>Логин</label>
                    <input type="text" name="username" required />
                    <label>Пароль</label>
                    <input type="text" name="password" required />
                    <label>Разрешения</label>
                    <select name="user_privilege">
                        <option value="Admin">Admin / Администратор</option>
                        <option value="Support">Support / Поддержка</option>
                        <option value="Viewer" selected>Viewer / Просмотр</option>
                    </select>

                    <input type="submit" value="Добавить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/UserUpdate">

                    @csrf

                    <label>Логин</label>
                    <input type="text" name="username" />
                    <label>Пароль</label>
                    <input type="text" name="password" />
                    <label>Разрешения</label>
                    <select name="user_privilege">
                        <option></option>
                        <option value="Admin">Admin / Администратор</option>
                        <option value="Support">Support / Поддержка</option>
                        <option value="Viewer">Viewer / Просмотр</option>
                    </select>
                    <label>Пользователь</label>
                    <select name="id">
                        @foreach ($result as $record)
                            <option value="{{ $record->id }}">
                                {{ $record->username }} &#40 ID: {{ $record->id }} &#41
                            </option>
                        @endforeach
                    </select>

                    <input type="submit" value="Изменить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/UserDelete">

                    @csrf

                    <label>Пользователь</label>
                    <select name="id">
                        @foreach ($result as $record)
                            <option value="{{ $record->id }}">
                                {{ $record->username }} &#40 ID: {{ $record->id }} &#41
                            </option>
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
