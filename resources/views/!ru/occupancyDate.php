<!DOCTYPE html>

<html>

<head>
    <title>Выбор даты</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/employeeFandT.css">
</head>

<?php
require "../db_conn.php";
require "../privileges/admin.php";
require "topBottom/navBar.php";
require "topBottom/footer.html";

$dateArray = array();
$query = 'SELECT `date` FROM availabledates';
$result = mysqli_query($conn, $query);
while ($record = mysqli_fetch_assoc($result)) {
    array_push($dateArray, $record['date']);
}
?>

<style>
    tr:hover {
        background-color: white !important;
    }

    input:hover {
        background-color: #21abc4 !important;
    }
</style>

<body>
    <div class="main-body">
        <div class="button-container-calendar">
            <button class="button-blue" id="previous" onclick="previous()">&#8249;</button>
            <button class="button-blue" id="next" onclick="next()">&#8250;</button>
        </div>

        <table class="table" id="calendar">
            <thead class="table-head" id="thead-month">
                <h3 id="monthAndYear"></h3>
            </thead>
            <tbody class="table-body" id="calendar-body"></tbody>
        </table>

        <label for="month">Перейти к: </label>
        <select id="month" onchange="jump()">
            <option value=0>Январь</option>
            <option value=1>Февраль</option>
            <option value=2>Март</option>
            <option value=3>Апрель</option>
            <option value=4>Май</option>
            <option value=5>Июнь</option>
            <option value=6>Июль</option>
            <option value=7>Август</option>
            <option value=8>Сентябрь</option>
            <option value=9>Октябрь</option>
            <option value=10>Ноябрь</option>
            <option value=11>Декабрь</option>
        </select>
        <select id="year" onchange="jump()"></select>
    </div>


</body>

<script src="../scripts/setDateOccupancy.js"></script>

<script>
    function dateFromJson() {
        var dateFromJson = <?php echo json_encode($dateArray); ?>;
        if (isEmpty(dateFromJson)) {
            dateFromJson = <?php
                            $dateArray = array(00000000);
                            echo json_encode($dateArray);

                            ?>;
        }

        return dateFromJson;
    }

    function isEmpty(obj) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop))
                return false;
        }

        return true;
    }

    function generate_year_range(start, end) {
        var years = "";
        for (var year = start; year <= end; year++) {
            years += "<option value='" + year + "'>" + year + "</option>";
        }
        return years;
    }
    dateJson = dateFromJson();

    today = new Date();
    currentMonth = today.getMonth();
    currentYear = today.getFullYear();
    selectYear = document.getElementById("year");
    selectMonth = document.getElementById("month");

    createYear = generate_year_range(currentYear - 1, currentYear + 1);

    document.getElementById("year").innerHTML = createYear;

    var calendar = document.getElementById("calendar");
    var lang = calendar.getAttribute('data-lang');

    var months = "";
    var days = "";

    var monthDefault = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

    var dayDefault = ["Вс.", "Пн.", "Вт.", "Ср.", "Чт.", "Пт.", "Сб."];

    months = monthDefault;
    days = dayDefault;

    var $dataHead = "<tr>";
    for (dhead in days) {
        $dataHead += "<th data-days='" + days[dhead] + "'>" + days[dhead] + "</th>";
    }
    $dataHead += "</tr>";

    document.getElementById("thead-month").innerHTML = $dataHead;

    monthAndYear = document.getElementById("monthAndYear");
    showCalendar(currentMonth, currentYear);

    function next() {
        currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
        currentMonth = (currentMonth + 1) % 12;
        showCalendar(currentMonth, currentYear);
    }

    function previous() {
        currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
        currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
        showCalendar(currentMonth, currentYear);
    }

    function jump() {
        currentYear = parseInt(selectYear.value);
        currentMonth = parseInt(selectMonth.value);
        showCalendar(currentMonth, currentYear);
    }

    function showCalendar(month, year) {

        var firstDay = (new Date(year, month)).getDay();

        tbl = document.getElementById("calendar-body");

        tbl.innerHTML = "";

        monthAndYear.innerHTML = months[month] + " " + year;
        selectYear.value = year;
        selectMonth.value = month;

        // creating all cells
        var date = 1;
        for (var i = 0; i < 6; i++) {

            var row = document.createElement("tr");

            for (var j = 0; j <= 6; j++) {
                if (i === 0 && j < firstDay) {
                    cell = document.createElement("td");
                    cellText = document.createTextNode("");
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                } else if (date > daysInMonth(month, year)) {
                    break;
                } else {
                    cell = document.createElement("td");

                    for (var t = 0; t < dateJson.length; t++) {
                        normalDate = JSON.stringify(dateJson[t])
                        normalDate = normalDate.replaceAll('"', '');

                        if (normalDate.substr(0, 4) == year &&
                            normalDate.substr(5, 2) == month + 1 &&
                            normalDate.substr(8, 2) == date) {
                            cell.innerHTML = "<td><input onclick='setDateOccupancy(" + year + ", " + month + ", " + date + ")' type='button' value='" + date + "'class='calendar-button-green'></td>";

                            break;
                        } else {
                            cell.innerHTML = "<td><input type='button' value='" + date + "'class='calendar-button'></td>";
                        }

                    }

                    if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                        cell.className = "date-picker selected";
                    }
                    row.appendChild(cell);
                    date++;
                }
            }
            tbl.appendChild(row);
        }
    }

    function daysInMonth(iMonth, iYear) {
        return 32 - new Date(iYear, iMonth, 32).getDate();
    }
</script>

</html>