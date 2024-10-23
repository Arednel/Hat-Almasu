<!DOCTYPE html>

<html>

<head>
    <title>{!! __('Подача заявки') !!}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/StandardForm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/StandardButtons.css') }}">

    @livewireStyles
    @livewireScripts
</head>

<body>
    @livewire('reason-form-switcher')
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
