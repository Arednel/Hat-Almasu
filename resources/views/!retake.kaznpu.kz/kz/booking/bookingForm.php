<form method="POST" enctype="multipart/form-data" class="formInputs">
    <a href="index.php">← Артқа</a>

    <input type="text" name="fullName" placeholder=" ТАӘ" required />
    <input type="number" name="idOfTest" min="1" max="9999999" placeholder=" ID теста" required />
    <input type="number" name="course" min="1" max="5" placeholder=" Курс" required />
    <input type="text" name="faculty" placeholder=" Институт (Факультет)" required />
    <select name="department" required>
        <option value="" disabled selected>Бөлімше</option>
        <option value="Каз.">Каз.</option>
        <option value="Рус.">Рус.</option>
        <option value="Анг.">Анг.</option>
    </select>
    <input type="text" name="speciality" placeholder=" Мамандық" required />
    <input type="text" name="subject" placeholder=" Пән атауы" required />
    <input type="email" name="mail" placeholder=" Байланыс поштасы" required />
    <input type="text" name="phoneNumber" placeholder=" Байланыс телфоны" required />
    <select name="reason">
        <option value="Технический сбой">Техникалық ақау</option>
        <option value="Апелляция">Апелляция</option>
    </select>
    <label for="file">
        Растайтын<br>
        құжат<br>
        (8 МБ дейін)
        <input id="file" type="file" accept="image/*" name="confirmationFile" required />
    </label>

    <input type="submit" value="Жіберу" class="button-blue">
</form>