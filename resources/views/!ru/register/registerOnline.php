<table class="table">
    <thead class="table-head">
        <tr>
            <th class="column" colspan="100%"><?php
                                                echo $chosenDate;
                                                ?>
                / Онлайн</th>
        </tr>
    </thead>
    <thead class="table-head">
        <tr>
            <th class="column">Онлайн </th>
            <th class="column-short">Нажмите, чтобы выбрать</th>
        </tr>
    </thead>
    <tbody class="table-body">
        <td class="column">
            &nbspОнлайн / <?php echo $chosenDate ?>
        </td>
        <td class="column-short">
            <input onclick="registerLogic('0', '1')" type="button" value="Выбрать" class="calendar-button-green">
        </td>
    </tbody>
</table>