<!DOCTYPE html>

<html>

<head>
    <title>Статус заявки</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manageForm.css') }}">
</head>

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

            @isset($availabledates)
                <form method="POST" action="/Register">

                    <a href="/">← Назад</a>

                    @csrf

                    <label>Выберите дату для пересдачи:</label>
                    <select name="date">
                        @foreach ($availabledates as $record)
                            <option value="{{ $record->date }}">{{ $record->date }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="mail" value="{{ $mail }}">
                    <input type="hidden" name="requestID" value="{{ $requestID }}">

                    <input type="submit" value="Выбрать" class="button-blue">
                </form>
            @else
                <form method="POST" action="/VerifyRequest">

                    @csrf

                    <a href="/">← Назад</a>

                    <input type="email" name="mail" value="" placeholder=" Почта, указанная в заявке" required />
                    <input type="number" name="requestID" value="" placeholder=" Номер заявки" required />
                    <br>
                    <input type="submit" value="Подтвердить" class="button-blue">
                </form>
            @endisset

        </div>
    </div>
</body>


</html>
