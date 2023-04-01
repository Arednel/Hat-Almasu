<!DOCTYPE html>

<html>

<head>
    <title>{!! __('Подача заявки') !!}</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manageForm.css') }}">

    <script src="{{ asset('scripts/jquery-3.6.4.min.js') }}"></script>
</head>

<body>
    <div class="main-body">
        <div class="modal-content">
            <img src="{{ asset('images/3.jpg') }}" class="formImage">

            <form method="POST" action="/RequestNew" enctype="multipart/form-data" class="formInputs">
                <a href="/">{!! __('← Назад') !!}</a>

                @csrf

                <input type="text" name="fullName" placeholder=" {!! __('ФИО') !!}" required />

                @error('fullName')
                    <p>{{ $message }}</p>
                @enderror

                <input type="number" name="idOfTest" min="1" max="9999999"
                    placeholder=" {!! __('ID теста') !!}" required />
                <input type="number" name="course" min="1" max="5"
                    placeholder=" {!! __('Курс') !!}" required />
                <select name="department" required>
                    <option value="" disabled selected>{!! __('Отделение') !!}</option>
                    <option value="Каз.">Каз.</option>
                    <option value="Рус.">Рус.</option>
                    <option value="Анг.">Анг.</option>
                </select>
                <select id="faculty" type="text" name="faculty" required>
                    <option value="" disabled selected>{!! __('Институт (Факультет)') !!}</option>
                    <option value="Институт Сорбонна-Казахстан">Институт Сорбонна-Казахстан</option>
                    <option value="Институт математики, физики и информатики">Институт математики, физики и информатики
                    </option>
                    <option value="Институт педагогики и психологии">Институт педагогики и психологии</option>
                    <option value="Институт Филологии">Институт Филологии</option>
                    <option value="Институт естествознания и географии">Институт естествознания и географии</option>
                    <option value="Институт искусств, культуры и спорта">Институт искусств, культуры и спорта</option>
                    <option value="Институт истории и права">Институт истории и права</option>
                </select>
                <select id="speciality" type="text" name="speciality" required>
                    <option value="" disabled selected>{!! __('Специальность') !!}</option>
                </select>
                <input type="text" name="subject" placeholder=" {!! __('Дисциплина (предмет)') !!}" required />
                <input type="email" name="mail" placeholder=" {!! __('Почта для связи') !!}" required />
                <input type="text" name="phoneNumber" placeholder=" {!! __('Номер телефона для связи') !!}" required />
                <select name="reason">
                    <option value="Технический сбой">{!! __('Технический сбой') !!}</option>
                    {{-- <option value="Апелляция">{!! __('Апелляция') !!}</option> --}}
                </select>
                <select name="examType">
                    <option value="Тестирование">{!! __('Тестирование') !!}</option>
                    <option value="Письменно">{!! __('Письменно') !!}</option>
                </select>
                <label for="file">{!! __('Подтверждаю-<br>щий документ<br>(До 8 МБ)') !!}
                    <input id="file" type="file" accept="image/*" name="confirmationFile" required />
                </label>

                <input type="submit" value="{!! __('Отправить') !!}" class="button-blue">
            </form>

        </div>
    </div>
</body>

<script>
    $.ajax({
        type: 'GET',
        url: '/RequestNew/options',
        success: function(options) {
            $('#faculty').change(function() {
                $('#speciality').empty();
                var chosenOption = $(this).val();
                $('#speciality').append(
                    '<option value="" disabled selected>{!! __('Специальность') !!}</option>'
                );
                $('#speciality').append(options[chosenOption]);
            });
        }
    });
</script>

<html>
