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

            @if (isset($rooms))
                <form method="POST" action="/Occupancy/Hour">
                    <a href="/">← На главную</a>

                    @csrf

                    <label>Выберите аудиторию для просмотра:</label>
                    <select name="roomID">
                        @foreach ($rooms as $record)
                            <option value="{{ $record->roomID }}">{{ $record->roomName }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="chosenDate" value="{{ $chosenDate }}">

                    <input type="submit" value="Выбрать" class="button-blue">
                </form>
            @elseif(isset($roomID))
                <form method="POST" action="/Occupancy/View">
                    <a href="/">← На главную</a>

                    @csrf

                    <label>Выберите время для просмотра:</label>
                    <select name="startHour">
                        @for ($i = $hours, $currentHour = $startHour; $i > 0; $i--, $currentHour++)
                            @php
                                $bookingRecordsAmount = DB::table('bookingrecords')
                                    ->where('bookingDate', $chosenDate)
                                    ->where('roomID', $roomID)
                                    ->where('startHour', $currentHour)
                                    ->count();
                                
                                $roomSpace = DB::table('rooms')
                                    ->where('roomID', $roomID)
                                    ->select('roomSpace')
                                    ->first();
                            @endphp
                            <option value="{{ $currentHour }}">C {{ $currentHour }}:00 до {{ $currentHour + 1 }}:00
                                (Занято
                                {{ $bookingRecordsAmount }} мест из {{ $roomSpace->roomSpace }})</option>
                        @endfor
                    </select>
                    <input type="hidden" name="chosenDate" value="{{ $chosenDate }}">
                    <input type="hidden" name="roomID" value="{{ $roomID }}">

                    <input type="submit" value="Выбрать" class="button-blue">
                </form>
            @else
                <form method="POST" action="/Occupancy/Room">
                    <a href="/">← На главную</a>

                    @csrf

                    <label>Выберите дату для просмотра:</label>
                    <select name="date">
                        @foreach ($availabledates as $record)
                            <option value="{{ $record->date }}">{{ $record->date }}
                                @if ($record->isOnline == true)
                                    (Онлайн)
                                @else
                                    (Оффлайн, c {{ $record->startHour }} до {{ $record->endHour }})
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <input type="submit" value="Выбрать" class="button-blue">
                </form>
            @endif

        </div>
    </div>
</body>

</html>
