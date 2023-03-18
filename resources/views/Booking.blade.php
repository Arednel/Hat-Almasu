<!DOCTYPE html>

<html>

<head>
    <title>Подача заявки</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manageForm.css') }}">
</head>

@php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
@endphp

<body>
    <div class="main-body">
        <div class="modal-content">
            <img src="{{ asset('images/3.jpg') }}" class="formImage">
            @include('./BookingForm')
        </div>
    </div>
</body>

<html>
