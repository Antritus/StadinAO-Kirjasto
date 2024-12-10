<?php
global $conn;
if (isset($_POST["submit"])) {

    // Get submitted data from the signup form
    $name = $_POST["add-name"];
    $surname = $_POST["add-sname"];
    $address = $_POST["add-address"];
    $postcode = $_POST["add-postcode"];
    $postarea = $_POST["add-postarea"];
    $email = $_POST["add-email"];
    $birthday = $_POST["add-birthdate"];
    $pswd = $_POST["add-pswd"];
    $pswdR = $_POST["add-pswdR"];
    $return = $_POST["return"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($name, $surname, $address, $postcode, $postarea, $email, $birthday, $pswd, $pswdR)) {
        header("location: ../$return?signup=field_empty");
        exit();
    }

    if (invalidEmail($email) === true){
        header("location: ../$return?signup=invalid_email");
        exit();
    }
    if (passwordDontMatch($pswd, $pswdR)){
        header("location: ../$return?signup=passwords_dont_match");
        exit();
    }

    if (emailAlreadyExists($conn, $email) !== false){
        header("location: ../$return?signup=email_already_exists");
        exit();
    }

    createUser($conn, $name, $surname, $birthday, $email, $pswd, $address, $postcode, $postarea);
} else {
    header("location: ../index.php");
    exit();
}
