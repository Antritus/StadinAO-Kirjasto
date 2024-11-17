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

    // Get submitted data from the signup form
    $isbn = $_POST["add-isbn"];
    $isbnBook = $_POST["add-isbn-book"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($isbn, $isbnBook)) {
        header("location: ../book.php?error=field_empty&isbn=$isbn");
        exit();
    }

    if (itemIsbnExists($conn, $isbn, $isbnBook)){
        header("location: ../book.php?error=isbn_already_exists&isbn={$_POST["add-isbn"]}");
        exit();
    }

    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 5){ // No permission
        header("location: ../index.php");
        exit();
    }

    addBookCopy($conn, $isbn, $isbnBook);
    header("location: ../book.php?isbn=$isbn");
} else {
    header("location: ../index.php");
    exit();
}
