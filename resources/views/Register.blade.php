<!DOCTYPE html>
<html>

<head>
    <title>{!! __('Статус заявки') !!}</title>

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

            @if (isset($availabledates))
                <form method="POST" action="/Register/Room">
                    <a href="/">{!! __('← На главную') !!}</a>

                    @csrf

                    <label>{!! __('Выберите дату для пересдачи:') !!}</label>
                    <select name="date">
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
                    <input type="hidden" name="mail" value="{{ $mail }}">
                    <input type="hidden" name="requestID" value="{{ $requestID }}">

                    <input type="submit" value="Выбрать" class="button-blue">
                </form>
            @elseif(isset($rooms))
                <form method="POST" action="/Register/Hour">
                    <a href="/">{!! __('← На главную') !!}</a>

                    @csrf

                    <label>{!! __('Выберите аудиторию для пересдачи:') !!}</label>
                    <select name="roomID">
                        @foreach ($rooms as $record)
                            <option value="{{ $record->roomID }}">{{ $record->roomName }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="mail" value="{{ $mail }}">
                    <input type="hidden" name="requestID" value="{{ $requestID }}">
                    <input type="hidden" name="chosenDate" value="{{ $chosenDate }}">

                    <input type="submit" value="Выбрать" class="button-blue">
                </form>
            @elseif(isset($roomID))
                <form method="POST" action="/Register/Complete">
                    <a href="/">{!! __('← На главную') !!}</a>

                    @csrf

                    <label>{!! __('Выберите время для пересдачи:') !!}</label>
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
                                
                                $leftSpace = $roomSpace->roomSpace - $bookingRecordsAmount;
                            @endphp
                            <option value="{{ $currentHour }}">{!! __('C') !!} {{ $currentHour }}:00
                                {!! __('до') !!}
                                {{ $currentHour + 1 }}:00
                                ({!! __('Осталось') !!}
                                {{ $leftSpace }} {!! __('мест') !!})</option>
                        @endfor
                    </select>
                    <input type="hidden" name="mail" value="{{ $mail }}">
                    <input type="hidden" name="requestID" value="{{ $requestID }}">
                    <input type="hidden" name="chosenDate" value="{{ $chosenDate }}">
                    <input type="hidden" name="roomID" value="{{ $roomID }}">

                    <input type="submit" value="{!! __('Выбрать') !!}" class="button-blue">
                </form>
            @else
                <form method="POST" action="/Register/Date">
                    <a href="/">{!! __('← На главную') !!}</a>

                    @csrf

                    <input type="email" name="mail" value="" placeholder=" {!! __('Почта, указанная в заявке') !!}"
                        required />
                    <input type="number" name="requestID" value="" placeholder=" {!! __('Номер заявки') !!}"
                        required />
                    <br>
                    <input type="submit" value="{!! __('Подтвердить') !!}" class="button-blue">
                </form>
            @endif

        </div>
    </div>
</body>

</html>
