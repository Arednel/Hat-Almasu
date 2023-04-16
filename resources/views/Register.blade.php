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

        @if (isset($availabledates))
            <form method="POST" action="/Register/Complete">
                <button onclick="location.href='/'" type="button"
                    class="standard-button">{!! __('← На главную') !!}</button>
                <br><br><br><br>

                @csrf

                <label>&nbsp{!! __('Выберите удобную дату, аудиторию и время:') !!}</label>
                <br>
                <br>
                <select id="date" name="chosenDate" required>
                    <option value="" disabled selected>{!! __('Дата') !!}</option>
                    @foreach ($availabledates as $record)
                        <option value="{{ $record->date }}">{{ $record->date }}
                            @if ($record->isOnline == true)
                                ({!! __('Онлайн') !!})
                            @else
                                ({!! __('Офлайн, c ') !!} {{ $record->startHour }} {!! __('до') !!}
                                {{ $record->endHour }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <select id="room" name="roomID" required>
                    <option value="" disabled selected>{!! __('Аудитория') !!}</option>
                </select>
                <select id="startHour" name="startHour" required>
                    <option value="" disabled selected>{!! __('Время') !!}</option>
                </select>
                <input type="hidden" name="mail" value="{{ $mail }}">
                <input type="hidden" name="requestID" value="{{ $requestID }}">

                <br><br><br>
                <div style="text-align:center">
                    <button type="submit" class="standard-button-long">{!! __('Выбрать') !!}</button>
                </div>
            </form>
        @else
            <form method="POST" action="/Register/Date">
                <button onclick="location.href='/'" type="button"
                    class="standard-button">{!! __('← На главную') !!}</button>
                <br><br><br><br>

                @csrf

                <input type="email" name="mail" value="" placeholder=" {!! __('Почта, указанная в заявке') !!}" required />
                <input type="number" name="requestID" value="" placeholder=" {!! __('Номер заявки') !!}"
                    required />

                <br><br><br>
                <div style="text-align:center">
                    <button type="submit" class="standard-button-long">{!! __('Выбрать') !!}</button>
                </div>
            </form>
        @endif
    </div>
</body>

<script src="{{ asset('scripts/jquery-3.6.4.min.js') }}"></script>
<script>
    var chosenDate;

    $('#date').change(function() {
        chosenDate = $(this).val();

        $('#room').empty();
        $('#room').append(
            '<option value="" disabled selected>{!! __('Аудитория') !!}</option>'
        );
        $('#startHour').empty();
        $('#startHour').append(
            '<option value="" disabled selected>{!! __('Время') !!}</option>'
        );

        $.ajax({
            type: 'GET',
            url: '/Register/Room',
            data: {
                chosenDate
            },
            success: function(rooms) {
                if (rooms.isOnline) {
                    $('#room').empty();
                    $('#room').append(
                        '<option value="isOnline" selected>{!! __('Онлайн') !!}</option>'
                    );
                    $('#startHour').empty();
                    $('#startHour').append(
                        '<option value="isOnline" selected>{!! __('Онлайн') !!}</option>'
                    );
                } else {
                    $('#room').append(rooms);
                }
            }
        });
    });

    $('#room').change(function() {
        $('#startHour').children().not(':first').remove();
        roomID = $(this).val();

        $.ajax({
            type: 'GET',
            url: '/Register/Hour',
            data: {
                chosenDate,
                roomID
            },
            success: function(hours) {
                $('#startHour').append(hours);
            }
        });
    });
</script>

<html>
