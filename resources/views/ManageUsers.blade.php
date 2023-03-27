<!DOCTYPE html>

<html>

<head>
    <title>Список пользователей</title>
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
                    <th class="column">Логин <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                    <th class="column">Пароль <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                    <th class="column">Уровень доступа <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                    <th class="column">ID пользователя <img src="{{ asset('images/sort.png') }}" class="Sort" /></th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($result as $record)
                    <tr>
                        <td class="column">
                            {{ $record->userName }}
                        </td>
                        <td class="column">
                            {{ $record->userPassword }}
                        </td>
                        <td class="column">
                            {{ $record->userPrivilege }}
                        </td>
                        <td class="column">
                            {{ $record->userID }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include ('/Components/pageSwitchingDiv')

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="/Manage/UserInsert">

                    @csrf

                    <label>Логин</label>
                    <input type="text" name="userName" required />
                    <label>Пароль</label>
                    <input type="text" name="userPassword" required />
                    <label>Разрешения</label>
                    <select name="userPrivilege">
                        <option value="Admin">Admin / Администратор</option>
                        <option value="Support" selected>Support / Поддержка</option>
                        <option value="Viewer" selected>Viewer / Просмотр</option>
                    </select>

                    <input type="submit" value="Добавить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/UserUpdate">

                    @csrf

                    <label>Логин</label>
                    <input type="text" name="userName" />
                    <label>Пароль</label>
                    <input type="text" name="userPassword" />
                    <label>Разрешения</label>
                    <select name="userPrivilege">
                        <option></option>
                        <option value="Admin">Admin / Администратор</option>
                        <option value="Support">Support / Поддержка</option>
                        <option value="Viewer">Viewer / Просмотр</option>
                    </select>
                    <label>Пользователь</label>
                    <select name="userID">
                        @foreach ($result as $record)
                            <option value="{{ $record->userID }}">
                                {{ $record->userName }} &#40 ID: {{ $record->userID }} &#41
                            </option>
                        @endforeach
                    </select>

                    <input type="submit" value="Изменить" class="button-blue">
                </form>
                <br>
                <form method="POST" action="/Manage/UserDelete">

                    @csrf

                    <label>Пользователь</label>
                    <select name="userID">
                        @foreach ($result as $record)
                            <option value="{{ $record->userID }}">
                                {{ $record->userName }} &#40 ID: {{ $record->userID }} &#41
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
