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

    $isbn = $_POST["extend-isbn"];
    $isbnBook = $_POST["extend-book-isbn"];
    $date = $_POST["extend-return_date"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($isbn, $date)) {
        header("location: ../book.php?error=field_empty&isbn=$isbn");
        exit();
    }

    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 5){ // No permission
        header("location: ../index.php");
        exit();
    }

    if (!isBorrowed($conn, $isbn, $isbnBook)){
        header("location: ../book.php?error=book_is_not_borrowed&isbn=$isbn&bookIsbn&$isbnBook");
        exit();
    }

    extendBorrow($conn, $isbn, $isbnBook, $date);
    header("location: ../book.php?isbn=$isbn");
} else {
    header("location: ../index.php");
    exit();
}
