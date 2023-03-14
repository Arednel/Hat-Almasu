<table class="table">
    <thead class="table-head">
        <tr>
            <th class="column" colspan="100%"><?php
                                                echo $chosenDate;
                                                ?>
                / Уақытты таңдаңыз</th>
        </tr>
    </thead>
    <thead class="table-head">
        <tr>
            <th class="column">Уақыт / Аудитория </th>
            <th class="column">Қол жетімді орындар саны</th>
            <th class="column-short">Таңдау үшін басыңыз</th>
        </tr>
    </thead>
    <tbody class="table-body">
        <?php
        $hoursArray = array();

        $query = "SELECT startHour, endHour FROM availabledates WHERE `date` = '$chosenDate'";
        $result1 = mysqli_query($conn, $query);
        $record = mysqli_fetch_assoc($result1);

        $startHour = $record['startHour'];
        $endHour = $startHour + 1;
        while ($startHour < $record['endHour']) {
            $query = "SELECT roomID, roomName, roomSpace FROM rooms";
            $result2 = mysqli_query($conn, $query);

            while ($rooms = mysqli_fetch_assoc($result2)) {
                $roomSpace = $rooms['roomSpace'];
                $roomID = $rooms['roomID'];
                //$roomID==1 это онлайн
                if (!($roomID == 1)) {
                    $bookingDate = $_SESSION['chosenDate'];
                    $query = "SELECT roomID FROM bookingrecords WHERE bookingdate = " . $bookingDate . " AND startHour = $startHour AND roomID = $roomID";
                    $result3 = mysqli_query($conn, $query);

                    while ($roomSpaces = mysqli_fetch_assoc($result3)) {
                        $roomSpace--;
                    }
                    echo '<tr>
                             <td class="column">
                                 C ' . $startHour . ':00 до ' . $endHour . ':00 / ' . $rooms['roomName'] . '
                             </td>
                             <td class="column">
                                 Тегін ' . $roomSpace . ' 
                             </td>';
                    if ($roomSpace > 0) {
                        echo '<td class="column-short">
                                 <input onclick="registerLogic(' . $startHour . ', ' . $roomID . ')" type="button" value="Таңдау" class="calendar-button-green">                    
                             </td>';
                    } else {
                        echo '<td class="column-short">
                            <input onclick="" type="button" value="Бос емес" class="calendar-button-red">
                             </td>';
                    }
                }
            }
            $startHour++;
            $endHour++;
        }
        ?>
    </tbody>
</table>