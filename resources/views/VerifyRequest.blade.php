<!DOCTYPE html>

<html>

<head>
    <title>Статус заявки</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manageForm.css') }}">
</head>

@include ('./VerifyRequest/VerifyRequestLogic');

<style>
    .formInputs {
        grid-column: 1 / 3;
    }

    a:link,
    a:visited {
        padding-bottom: 0;
        height: 6vh;
    }
</style>

<body>
    <div class="main-body">
        <div class="modal-content">
            <img src="{{ asset('images/3.jpg') }}" class="formImage">

            @include ('./VerifyRequest/VerifyRequestForm');
        </div>
    </div>
</body>


</html>
