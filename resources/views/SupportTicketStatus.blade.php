<!DOCTYPE html>

<html>

<head>
    <title>{!! __('Статус заявки') !!}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/StandardForm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/StandardButtons.css') }}">
</head>

<body>
    <div class="main-block">
        <div class="form-image" style="background-image: url('{{ asset('images/3.jpg') }}');"></div>

        <form method="POST" action="/SupportTicketStatus">
            <button onclick="location.href='/'" type="button" class="standard-button">{!! __('← На главную') !!}</button>
            <br><br><br><br>

            @csrf

            @error('email')
                <p>{{ $message }}</p>
            @enderror
            <input id="email" type="mail" name="email" placeholder=" {!! __('Почта, указанная в заявке') !!}" required />


            @error('supportTicketID')
                <p>{{ $message }}</p>
            @enderror
            <input id="supportTicketID" type="number" name="supportTicketID" placeholder=" {!! __('Номер заявки') !!}"
                required />

            <br><br><br>
            <div style="text-align:center">
                <button type="submit" class="standard-button-long">{!! __('Выбрать') !!}</button>
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
    // Charater "a" with \\, because it is special character
    $('#email').inputmask({
        mask: "*{1,20}@\\alm\\au.edu.kz",
    });
</script>

<html>
