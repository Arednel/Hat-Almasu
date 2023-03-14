<form method="POST">
    <label>Год</label>
    <select name="year">
        <option value="2022">2022</option>
        <option value="2023">2023</option>
    </select>
    <label>Месяц</label>
    <select name="month">
        <option value="01">Январь</option>
        <option value="02">Февраль</option>
        <option value="03">Март</option>
        <option value="04">Апрель</option>
        <option value="05">Май</option>
        <option value="06">Июнь</option>
        <option value="07">Июль</option>
        <option value="08">Август</option>
        <option value="09">Сентябрь</option>
        <option value="10">Октябрь</option>
        <option value="11">Ноябрь</option>
        <option value="12">Декабрь</option>
    </select>
    <label>День</label>
    <select name="day">
        <?php
        $days = 1;

        while ($days < 32) {
            echo '<option value="' . $days . '">' . $days . '</option>';
            $days++;
        }
        ?>
    </select>
    <label>С</label>
    <select name="startHour">
        <option value="9" selected>9:00</option>
        <option value="10">10:00</option>
        <option value="11">11:00</option>
        <option value="12">12:00</option>
        <option value="13">13:00</option>
        <option value="14">14:00</option>
        <option value="15">15:00</option>
        <option value="16">16:00</option>
        <option value="17">17:00</option>
    </select>
    <label>До</label>
    <select name="endHour">
        <option value="10">10:00</option>
        <option value="11">11:00</option>
        <option value="12">12:00</option>
        <option value="13">13:00</option>
        <option value="14">14:00</option>
        <option value="15">15:00</option>
        <option value="16">16:00</option>
        <option value="17">17:00</option>
        <option value="18" selected>18:00</option>
    </select>
    <label>Онлайн</label>
    <input type="checkbox" name="isOnline" value="1">

    <input type="submit" value="Добавить" class="button-blue">
</form>
<br>
<form method="POST">
    <label>Дата</label>
    <select name="date">
        <?php
        $query = 'SELECT `date` FROM availabledates ORDER BY `date`';
        $result = mysqli_query($conn, $query);

        while ($record = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $record['date'] . '">' . $record['date'] . '</option>';
        }
        ?>
    </select>

    <input type="submit" value="Удалить дату" class="button-blue">
</form>