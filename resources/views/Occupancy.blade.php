<!DOCTYPE html>
<html>

<head>
    <title>Статус заявки</title>

    <link rel="stylesheet" href="{{ asset('css/StandardForm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/StandardButtons.css') }}">
</head>

<body>
    <div class="main-block">
        <div class="form-image" style="background-image: url('{{ asset('images/3.jpg') }}');"></div>

        <form method="POST" action="/Occupancy/View">
            <button onclick="location.href='/'" type="button" class="standard-button">{!! __('← На главную') !!}</button>
            <br><br><br><br>

            @csrf

            <label>&nbspВыберите дату, аудиторию и время:</label>
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
                        (Сессия №{{ $record->examSessionID }})
                    </option>
                @endforeach
            </select>
            <select id="room" name="roomID" required>
                <option value="" disabled selected>{!! __('Аудитория') !!}</option>
            </select>
            <select id="startHour" name="startHour" required>
                <option value="" disabled selected>{!! __('Время') !!}</option>
            </select>

            <br><br><br>
            <div style="text-align:center">
                <button type="submit" class="standard-button-long">{!! __('Выбрать') !!}</button>
            </div>
        </form>

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
            url: '/Occupancy/Room',
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
            url: '/Occupancy/Hour',
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

</html>
