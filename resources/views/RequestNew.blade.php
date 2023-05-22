<!DOCTYPE html>

<html>

<head>
    <title>{!! __('Подача заявки') !!}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

            @error('fullName')
                <p>{{ $message }}</p>
            @enderror
            <input type="text" name="fullName" placeholder=" {!! __('ФИО') !!}" required />


            @error('idOfTest')
                <p>{{ $message }}</p>
            @enderror
            <input type="number" name="idOfTest" min="1" max="9999999" placeholder=" {!! __('ID теста') !!}"
                required />

            @error('course')
                <p>{{ $message }}</p>
            @enderror
            <input type="number" name="course" min="1" max="5" placeholder=" {!! __('Курс') !!}"
                required />

            @error('department')
                <p>{{ $message }}</p>
            @enderror
            <select name="department" required>
                <option value="" disabled selected>{!! __('Отделение') !!}</option>
                <option value="Каз.">Каз.</option>
                <option value="Рус.">Рус.</option>
                <option value="Анг.">Анг.</option>
            </select>

            @error('faculty')
                <p>{{ $message }}</p>
            @enderror
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

            @error('speciality')
                <p>{{ $message }}</p>
            @enderror
            <select id="speciality" name="speciality" required>
                <option value="" disabled selected>{!! __('Специальность') !!}</option>
            </select>

            @error('subject')
                <p>{{ $message }}</p>
            @enderror
            <input type="text" name="subject" placeholder=" {!! __('Дисциплина (предмет)') !!}" required />

            @error('mail')
                <p>{{ $message }}</p>
            @enderror
            <input id="email" type="email" name="mail" placeholder=" {!! __('Почта для связи') !!}" required />

            @error('phoneNumber')
                <p>{{ $message }}</p>
            @enderror
            <input id="phoneNumber" type="text" name="phoneNumber" placeholder=" {!! __('Номер телефона для связи') !!}"
                required />

            @error('reason')
                <p>{{ $message }}</p>
            @enderror
            <select name="reason">
                <optgroup label="{!! __('Причина') !!}">
                    <option value="Технический сбой">{!! __('Технический сбой') !!}</option>
                    <option value="По оплате">{!! __('По оплате') !!}</option>
                </optgroup>
            </select>

            @error('examType')
                <p>{{ $message }}</p>
            @enderror
            <select name="examType">
                <optgroup label="{!! __('Тип теста') !!}">
                    <option value="Тестирование">{!! __('Тестирование') !!}</option>
                    <option value="Письменно">{!! __('Письменно') !!}</option>
                </optgroup>
            </select>

            <div style="text-align:center">
                @error('confirmationFile')
                    <p>{{ $message }}</p>
                @enderror
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
<script src="{{ asset('scripts/jquery.inputmask.js') }}"></script>
<script>
    $('#phoneNumber').inputmask({
        'mask': '+7 999 999 99-99'
    });
</script>

<html>
