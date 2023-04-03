<!DOCTYPE html>

<html>

<head>
    <title>{!! __('Подача заявки') !!}</title>

    <link rel="stylesheet" href="{{ asset('css/StandardForm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/StandardButtons.css') }}">
</head>

<body>
    <div class="main-block">
        <div class="form-image" style="background-image: url('{{ asset('images/3.jpg') }}');"></div>

        <form method="POST" action="/RequestNew" enctype="multipart/form-data">
            <button onclick="location.href='/'" type="button" class="standard-button">{!! __('← Назад') !!}</button>
            <br><br><br><br>

            @csrf

            <input type="text" name="fullName" placeholder=" {!! __('ФИО') !!}" required />

            @error('fullName')
                <p>{{ $message }}</p>
            @enderror

            <input type="number" name="idOfTest" min="1" max="9999999" placeholder=" {!! __('ID теста') !!}"
                required />
            <input type="number" name="course" min="1" max="5" placeholder=" {!! __('Курс') !!}"
                required />
            <select name="department" required>
                <option value="" disabled selected>{!! __('Отделение') !!}</option>
                <option value="Каз.">Каз.</option>
                <option value="Рус.">Рус.</option>
                <option value="Анг.">Анг.</option>
            </select>
            <select id="faculty" name="faculty" required>
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
            <select id="speciality" name="speciality" required>
                <option value="" disabled selected>{!! __('Специальность') !!}</option>
            </select>
            <input type="text" name="subject" placeholder=" {!! __('Дисциплина (предмет)') !!}" required />
            <input type="email" name="mail" placeholder=" {!! __('Почта для связи') !!}" required />
            <input type="tel" name="phoneNumber" minlength="11" placeholder=" {!! __('Номер телефона для связи') !!}" required />
            <select name="reason">
                <option value="Технический сбой">{!! __('Технический сбой') !!}</option>
            </select>
            <select name="examType">
                <option value="Тестирование">{!! __('Тестирование') !!}</option>
                <option value="Письменно">{!! __('Письменно') !!}</option>
            </select>
            <div style="text-align:center">
                <label for="file">&nbsp{!! __('Подтверждающий документ (До 8 МБ)') !!}
                    <input id="file" type="file" accept="image/*" name="confirmationFile"
                        class="test"required />
                </label>
            </div>

            <div style="text-align:center">
                <button type="submit" class="standard-button-long">{!! __('Отправить') !!}</button>
            </div>
        </form>
    </div>
</body>

<script src="{{ asset('scripts/jquery-3.6.4.min.js') }}"></script>
<script>
    var options = @json($options);

    $('#faculty').change(function() {
        $('#speciality').empty();
        var chosenOption = $(this).val();
        $('#speciality').append(
            '<option value="" disabled selected>{!! __('Специальность') !!}</option>'
        );

        $('#speciality').append(options[chosenOption]);
    });
</script>

<html>
