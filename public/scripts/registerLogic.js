function registerLogic(startHour, roomID) {
    document.cookie = "startHour =" + startHour;
    document.cookie = "roomID =" + roomID;

    window.location.href = "register/registerLogic.php";
}