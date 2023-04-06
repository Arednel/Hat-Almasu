<!DOCTYPE html>

<html>

<head>
    <title>Test</title>
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
                <col style="width: 4%" />
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
                    <th>Решение</th>
            </thead>
            <tbody>
                <tr>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2</td>
                    <td><button class="button-image-view" type="button" target="_blank" onclick="window.open('/1')"
                            class="table-approval">
                            Перейти к файлу
                        </button></td>
                    <td><button class="button-approve" type="button" target="_blank" onclick="window.location=('/2')"
                            class="table-approval-green">
                            ✓
                        </button>
                        <button class="button-reject" type="button" target="_blank" onclick="window.location=('/3')"
                            class="table-approval-green">
                            x
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td><button class="button-image-view" type="button" target="_blank" onclick="window.open('/1')"
                            class="table-approval">
                            Перейти к файлу
                        </button></td>
                    <td><button class="button-approve"type="button" target="_blank" onclick="window.location=('/2')"
                            class="table-approval-green">
                            ✓
                        </button>
                        <button class="button-reject" type="button" target="_blank" onclick="window.location=('/3')"
                            class="table-approval-green">
                            x
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>lotlotlotlotlotlotlotlotlotlotlotlotlotlotlotlotlotlotlotlot
                    </td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td><button class="button-image-view" type="button" target="_blank" onclick="window.open('/1')"
                            class="table-approval">
                            Перейти к файлу
                        </button></td>
                    <td><button class="button-approve" type="button" target="_blank" onclick="window.location=('/2')"
                            class="table-approval-green">
                            ✓
                        </button><button class="button-approve" type="button" target="_blank"
                            onclick="window.location=('/2')" class="table-approval-green">
                            ✓
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                </tr>

            </tbody>
        </table>
        <br>
        <br>
    </div>

</body>

<script src="{{ asset('scripts/sort.js') }}"></script>

</html>
