function setDateOccupancy(year, month, day) {
    month++;

    if (month < 10) {
        month = '0' + String(month);
    }
    if (day < 10) {
        day = '0' + String(day);
    }

    fullDate = String(year) + "." + String(month) + "." + String(day);
    document.cookie = "chosenDate =" + fullDate;

    window.location.href = "hourOccupancy.php";
}