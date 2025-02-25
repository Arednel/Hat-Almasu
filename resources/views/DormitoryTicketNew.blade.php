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

        <form method="POST" action="/DormitoryTicketNew" enctype="multipart/form-data">
            <button onclick="location.href='/'" type="button" class="standard-button">{!! __('← Назад') !!}</button>
            <br><br><br><br>

            @csrf

            @error('fullName')
                <p>{{ $message }}</p>
            @enderror
            <input type="text" name="fullName" placeholder=" {!! __('ФИО') !!}" required />

            @error('course')
                <p>{{ $message }}</p>
            @enderror
            <input type="number" name="course" min="1" max="4" placeholder=" {!! __('Курс') !!}"
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

            <select required>
                @error('reason')
                    <p>{{ $message }}</p>
                @enderror
                <optgroup label="Социальный пакет">
                    <option disabled selected value hidden style="red-text-color">{!! __('Социальный пакет') !!}</option>
                    <option value="Присутствует">{!! __('Присутствует') !!}</option>
                    <option value="Отсутствует">{!! __('Отсутствует') !!}</option>
                </optgroup>
            </select>

            @error('extraTextInfo')
                <p>{{ $message }}</p>
            @enderror
            <textarea id="extraTextInfo" type="textarea" name="extraTextInfo" placeholder="{!! __('Дополнительная информация (не обязательно)') !!}"></textarea>

            @error('email')
                <p>{{ $message }}</p>
            @enderror
            <input id="email" type="mail" name="email" placeholder=" {!! __('Почта для связи') !!}" required />

            @error('phoneNumber')
                <p>{{ $message }}</p>
            @enderror
            <input id="phoneNumber" type="text" name="phoneNumber" placeholder=" {!! __('Номер телефона для связи') !!}"
                required />

            <div style="text-align:center">
                @error('confirmationImage.*')
                    <p>{{ $message }}</p>
                @enderror
                @error('confirmationImage')
                    <p>{{ $message }}</p>
                @enderror
                <label for="file">&nbsp{!! __('Подтверждающие изображения (До 10 МБ, до 5 изображений)') !!}
                    <input id="file" type="file" accept="image/*" name="confirmationImage[]" multiple
                        class="test" />
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
    integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#phoneNumber').inputmask({
        'mask': '+7 999 999 99-99'
    });
</script>

<html>
