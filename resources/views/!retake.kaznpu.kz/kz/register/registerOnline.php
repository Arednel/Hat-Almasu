<table class="table">
    <thead class="table-head">
        <tr>
            <th class="column" colspan="100%"><?php
                                                echo $chosenDate;
                                                ?>
                / Желіде</th>
        </tr>
    </thead>
    <thead class="table-head">
        <tr>
            <th class="column">Желіде </th>
            <th class="column-short">Таңдау үшін басыңыз</th>
        </tr>
    </thead>
    <tbody class="table-body">
        <td class="column">
            &nbspЖеліде / <?php echo $chosenDate ?>
        </td>
        <td class="column-short">
            <input onclick="registerLogic('0', '1')" type="button" value="Выбрать" class="calendar-button-green">
        </td>
    </tbody>
</table>