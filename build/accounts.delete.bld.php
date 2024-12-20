<?php
global $conn;


if (isset($_POST["submit"])) {
    session_start();
    if (!isset($_SESSION["permission"])){
        header("location: ../index.php?ee=ee");
    }
    if (!isset($_SESSION["permission"]) || $_SESSION["permission"] < 5){
        header("location: ../index.php?ee={$_SESSION["permission"]}");
        exit();
    }

    $id = $_POST["delete-id"];
    $return = $_POST["return"];
    if ($return==null){
        $return = "accounts.php";
    }

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($id)) {
        header("location: ../$return?error=field_empty&isbn=$id");
        exit();
    }

    $books = getBorrowedAccount($conn, $id);

    if (isset($books) && sizeof($books) > 0){
        header("location: ../$return?error=returns_not_returned&isbn=$id");
        exit();
    }

    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 10){ // No permission
        header("location: ../index.php");
        exit();
    }

    deleteAccount($conn, $id);
    header("location: ../$return?isbn=$id");
} else {
    header("location: ../index.php");
    exit();
}
