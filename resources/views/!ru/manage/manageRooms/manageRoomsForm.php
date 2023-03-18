<form method="POST">
    <label>Название аудитории</label>
    <input type="text" name="roomName" required />
    <label>Количество мест</label>
    <input type="number" name="roomSpace" max="1000" required />

    <input type="submit" value="Добавить новый" class="button-blue">
</form>
<br>
<form method="POST">
    <label>Название аудитории</label>
    <input type="text" name="roomNameChange" />
    <label>Количество мест</label>
    <input type="number" name="roomSpaceChange" max="1000" />
    <label>Аудитория</label>
    <select name="roomIDChange">
        <?php
        $query = 'SELECT roomID, roomName FROM rooms ORDER BY roomName';
        $result = mysqli_query($conn, $query);

        while ($record = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $record['roomID'] . '">' . $record['roomName'] . '</option>';
        }
        ?>
    </select>

    <input type="submit" value="Изменить" class="button-blue">
</form>
<br>
<form method="POST">
    <label>Аудитория</label>
    <select name="roomID">
        <?php
        $query = 'SELECT roomID, roomName FROM rooms ORDER BY roomName';
        $result = mysqli_query($conn, $query);

        while ($record = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $record['roomID'] . '">' . $record['roomName'] . '</option>';
        }
        ?>
    </select>

    <input type="submit" value="Удалить" class="button-blue">
</form>