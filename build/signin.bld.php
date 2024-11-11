<?php
global $conn;
if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $pswd = $_POST["pswd"];
    $stayLogged = isset($_POST["remember"]) ? $_POST["remember"] : null;

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($email, $pswd)) {
        header("location: ../index.php?signin=field_empty");
        exit();
    }

    /*
    if (invalidEmail($email) === true) {
        header("location: ../index.php?signin=invalid_email");
        exit();
    }
    */

    if (login($conn, $email, $pswd) === false) {
        header("location: ../index.php?signin=invalid_email_or_password");
        exit();
    }

    header("location: ../index.php");
} else {
    header("location: ../index.php?signin=true");
}
exit();
