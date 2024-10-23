<div class="main-block">
    <div class="form-image" style="background-image: url('{{ asset('images/3.jpg') }}');"></div>

    <form method="POST" action="/SupportTicketNew" enctype="multipart/form-data">
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

        @error('student_login')
            <p>{{ $message }}</p>
        @enderror
        <input type="text" name="student_login" placeholder=" Логин Moodle/Platonus" required />

        <select id="reason" name="reason" wire:model="selectedReason" required>
            @error('reason')
                <p>{{ $message }}</p>
            @enderror
            <optgroup label="Ошибка">
                <option disabled selected value hidden style="red-text-color">Выберите вашу ошибку</option>
                <option value="Неверный пароль">Неверный пароль / необходимо сбросить пароль</option>
                <option value="Добавление на дисциплину">Добавление на дисциплину - необходимо добавить вас на
                    дисциплину</option>
                <option value="Удаление с дисциплины">Удаление с дисциплины - необходимо удалить вас с дисциплины
                </option>
                <option value="Другая ошибка">Другая ошибка</option>
            </optgroup>
        </select>

        @if ($selectedReason === 'Неверный пароль')
            @error('student_password')
                <p>{{ $message }}</p>
            @enderror
            <input type="text" name="student_password" placeholder=" Введите пароль" required />
        @elseif($selectedReason === 'Добавление на дисциплину')
            @error('subjects_to_add')
                <p>{{ $message }}</p>
            @enderror
            <input type="text" name="subjects_to_add"
                placeholder=" Введите название дисциплины/дисциплин через запятую" required />
        @elseif($selectedReason === 'Удаление с дисциплины')
            @error('subjects_to_remove')
                <p>{{ $message }}</p>
            @enderror
            <input type="text" name="subjects_to_remove"
                placeholder=" Введите название дисциплины/дисциплин через запятую" required />
        @endif

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
        <input id="phoneNumber" type="text" name="phoneNumber" placeholder=" {!! __('Номер телефона для связи') !!}" required />

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
