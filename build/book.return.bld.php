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

    $isbn = $_POST["return-isbn"];
    $isbnBook = $_POST["return-book-isbn"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($isbn, $isbn, $isbnBook)) {
        header("location: ../book.php?error=field_empty&isbn=$isbn");
        exit();
    }

    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 5){ // No permission
        header("location: ../index.php");
        exit();
    }

    cancelBorrow($conn, $isbn, $isbnBook);
    header("location: ../book.php?isbn=$isbn");
} else {
    header("location: ../index.php");
    exit();
}
