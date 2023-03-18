<?php
if (isset($_POST["roomName"])) {
    $roomName = $_POST["roomName"];
    $roomSpace = $_POST["roomSpace"];

    $query = "INSERT INTO rooms(roomName, roomSpace) VALUES ('$roomName', '$roomSpace')";
    mysqli_query($conn, $query);
}

if (isset($_POST["roomIDChange"])) {
    $roomIDChange = $_POST["roomIDChange"];

    if (isset($_POST["roomNameChange"]) && strlen($_POST["roomNameChange"])) {
        $roomNameChange = $_POST["roomNameChange"];
        $query = "UPDATE `rooms` SET `roomName`='$roomNameChange' WHERE `roomID`=$roomIDChange";
        mysqli_query($conn, $query);
    }

    if (isset($_POST["roomSpaceChange"]) && strlen($_POST["roomSpaceChange"])) {
        $roomSpaceChange = $_POST["roomSpaceChange"];
        $query = "UPDATE `rooms` SET `roomSpace`='$roomSpaceChange' WHERE `roomID`=$roomIDChange";
        mysqli_query($conn, $query);
    }
}

if (isset($_POST["roomID"])) {
    $roomID = $_POST["roomID"];

    $query = "DELETE FROM `rooms` WHERE roomID=$roomID";
    mysqli_query($conn, $query);
}
