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

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    $isbn = $_POST["delete-isbn"];
    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 10){ // No permission
        header("location: ../index.php");
        exit();
    }

    if (anyFieldsEmpty($isbn)) {
        header("location: ../books.php?error=field_empty");
        exit();
    }

    deleteBook($conn, $isbn);
    deleteItems($conn, $isbn);
    header("location: ../books.php");
} else {
    header("location: ../index.php");
    exit();
}
