<?php
if (isset($_POST["userName"])) {
    $userName = $_POST["userName"];
    $userPassword = $_POST["userPassword"];
    $userPrivilege = $_POST["userPrivilege"];

    $query = "INSERT INTO users(userName, userPassword, userPrivilege) VALUES ('$userName','$userPassword','$userPrivilege')";
    mysqli_query($conn, $query);
}

if (isset($_POST["userIDChange"])) {

    $userIDChange = $_POST["userIDChange"];

    if (isset($_POST["userNameChange"]) && strlen($_POST["userNameChange"])) {
        $userNameChange = $_POST["userNameChange"];
        $query = "UPDATE `users` SET `userName`='$userNameChange' WHERE `userID`=$userIDChange";
        mysqli_query($conn, $query);
    }

    if (isset($_POST["userPasswordChange"]) && strlen($_POST["userPasswordChange"])) {
        $userPasswordChange = $_POST["userPasswordChange"];
        $query = "UPDATE `users` SET `userPassword`='$userPasswordChange' WHERE `userID`=$userIDChange";
        mysqli_query($conn, $query);
    }

    if (isset($_POST["userPrivilegeChange"]) && strlen($_POST["userPrivilegeChange"])) {
        $userPrivilegeChange = $_POST["userPrivilegeChange"];
        $query = "UPDATE `users` SET `userPrivilege`='$userPrivilegeChange' WHERE `userID`=$userIDChange";
        mysqli_query($conn, $query);
    }
}

if (isset($_POST["userID"])) {
    $userID = $_POST["userID"];

    $query = "DELETE FROM `users` WHERE userID=$userID";
    mysqli_query($conn, $query);
}
