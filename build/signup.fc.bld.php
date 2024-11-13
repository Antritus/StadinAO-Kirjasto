<?php
global $conn;
if (isset($_POST["submit"])) {

    // Get submitted data from the signup form
    $name = $_POST["name"];
    $surname = $_POST["sname"];
    $address = $_POST["address"];
    $postcode = $_POST["postcode"];
    $postarea = $_POST["postarea"];
    $email = $_POST["email"];
    $birthday = $_POST["birthdate"];
    $pswd = $_POST["pswd"];
    $pswdR = $_POST["pswdR"];
    $stayLogged = $_POST["remember"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($name, $surname, $address, $postcode, $postarea, $email, $birthday, $pswd, $pswdR, $stayLogged)) {
        header("location: ../account.php?signup=field_empty");
        exit();
    }

    if (invalidEmail($email) === true){
        header("location: ../account.php?signup=invalid_email");
        exit();
    }
    if (passwordDontMatch($pswd, $pswdR)){
        header("location: ../account.php?signup=passwords_dont_match");
        exit();
    }

    if (emailAlreadyExists($conn, $email) !== false){
        header("location: ../account.php?signup=email_already_exists");
        exit();
    }

    createUser($conn, $name, $surname, $birthday, $email, $pswd, $address, $postcode, $postarea);
} else {
    header("location: ../account.php?signup=true");
    exit();
}
