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
                <option value="" disabled selected>{!! __('Школа (Факультет)') !!}</option>
                <option value="Школа Менеджмента">Школа Менеджмента</option>
                <option value="Школа Экономики и Финансов">Школа Экономики и Финансов</option>
                <option value="Школа Предпринимательства и Инноваций">Школа Предпринимательства и Инноваций</option>
                <option value="Школа Цифровых Технологий">Школа Цифровых Технологий</option>
                <option value="Школа Политики и Права">Школа Политики и Права</option>
                <option value="Школа Гостеприимства и туризма">Школа Гостеприимства и туризма</option>
                <option value="Школа Медиа и Кино">Школа Медиа и Кино</option>
                <option value="Школа Transformative Humanities">Школа Transformative Humanities</option>
                <option value="Школа Урбанистики">Школа Урбанистики</option>
            </select>

            @error('speciality')
                <p>{{ $message }}</p>
            @enderror
            <select id="speciality" name="speciality" required>
                <option value="" disabled selected>{!! __('Специальность') !!}</option>
                <option value="Менеджмент">Менеджмент</option>
                <option value="Маркетинг">Маркетинг</option>
                <option value="Бизнес администрирование в области предпринимательства">Бизнес администрирование в
                    области предпринимательства</option>
                <option value="Урбанистика и сити-менеджмент">Урбанистика и сити-менеджмент</option>
                <option value="Global Management">Global Management</option>
                <option value="Финансы">Финансы</option>
                <option value="Бизнес аналитика и экономика">Бизнес аналитика и экономика</option>
                <option value="International Trade">International Trade</option>
                <option value="Учет и аудит">Учет и аудит</option>
                <option value="Юриспруденция">Юриспруденция</option>
                <option value="Спортивная психология">Спортивная психология</option>
                <option value="Психология образования">Психология образования</option>
                <option value="Ресторанное дело и гостиничный бизнес">Ресторанное дело и гостиничный бизнес</option>
                <option value="Туризм и ивент-менеджмент">Туризм и ивент-менеджмент</option>
                <option value="Логистика">Логистика</option>
                <option value="Информационные системы">Информационные системы</option>
                <option value="New Media">New Media</option>
                <option value="Digital Film Making">Digital Film Making</option>
                <option value="Software Engineering">Software Engineering</option>
                <option value="Data Science">Data Science</option>
                <option value="Product Management">Product Management</option>
                <option value="Business Analytics and Big Data">Business Analytics and Big Data</option>
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
                    <option value="Апелляция">{!! __('Апелляция') !!}</option>
                    <option value="Техническая ошибка">{!! __('Техническая ошибка') !!}</option>
                </optgroup>
            </select>

            @error('examType')
                <p>{{ $message }}</p>
            @enderror
            <select name="examType">
                <option value="Тестирование">{!! __('Тестирование') !!}</option>
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

<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

{{-- Removed for AlmaU --}}
{{-- <script>
    var options = @json($options);

    $('#faculty').change(function() {
        $('#speciality').empty();
        var chosenOption = $(this).val();
        $('#speciality').append(
            '<option value="" disabled selected>{!! __('Специальность') !!}</option>'
        );

        $('#speciality').append(options[chosenOption]);
    });
</script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
    integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#phoneNumber').inputmask({
        'mask': '+7 999 999 99-99'
    });
</script>

<html>
