<form method="POST" action="/NewRequest" enctype="multipart/form-data" class="formInputs">
    <a href="/">← Назад</a>

    @csrf

    <input type="text" name="fullName" placeholder=" ФИО" required />
    @error('fullName')
        <p>{{ $message }}</p>
    @enderror

    <input type="number" name="idOfTest" min="1" max="9999999" placeholder=" ID теста" required />
    <input type="number" name="course" min="1" max="5" placeholder=" Курс" required />
    <input type="text" name="faculty" placeholder=" Институт (Факультет)" required />
    <select name="department" required>
        <option value="" disabled selected>Отделение</option>
        <option value="Каз.">Каз.</option>
        <option value="Рус.">Рус.</option>
        <option value="Анг.">Анг.</option>
    </select>
    <input type="text" name="speciality" placeholder=" Специальность" required />
    <input type="text" name="subject" placeholder=" Дисциплина" required />
    <input type="email" name="mail" placeholder=" Почта для связи" required />
    <input type="text" name="phoneNumber" placeholder=" Номер телефона для связи" required />
    <select name="reason">
        <option value="Технический сбой">Технический сбой</option>
        <option value="Апелляция">Апелляция</option>
    </select>
    <label for="file">
        Подтверждаю-<br>
        щий документ<br>
        (До 8 МБ)
        <input id="file" type="file" accept="image/*" name="confirmationFile" required />
    </label>

    <input type="submit" value="Отправить" class="button-blue">
</form>
