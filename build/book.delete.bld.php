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
    $isbn = $_POST["delete-isbn"];
    $isbnBook = $_POST["delete-isbn-book"];
    $return = $_POST["return"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($isbn, $isbnBook)) {
        header("location: ../$return?error=field_empty&isbn=$isbn");
        exit();
    }

    if (itemIsbnExists($conn, $isbn, $isbnBook)){
        header("location: ../$return?error=isbn_already_exists&isbn={$_POST["add-isbn"]}");
        exit();
    }

    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 5){ // No permission
        header("location: ../index.php");
        exit();
    }

    deleteBookCopy($conn, $isbn, $isbnBook);
    header("location: ../$return?isbn=$isbn");
} else {
    header("location: ../index.php");
    exit();
}
