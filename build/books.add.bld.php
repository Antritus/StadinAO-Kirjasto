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
    $name = $_POST["add-book-name"];
    $author = $_POST["add-author"];
    $publisher = $_POST["add-publisher"];
    $published = $_POST["add-published"];
    $language = $_POST["add-language"];
    $isbn = $_POST["add-isbn"];
    $description = $_POST["add-description"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($name, $author, $publisher, $published, $language, $isbn, $description)) {
        header("location: ../books.php?error=field_empty");
        exit();
    }

    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 5){ // No permission
        header("location: ../index.php");
        exit();
    }

    createBook($conn, $name, $author, $publisher, $published, $language, $isbn, $description);
    header("location: ../books.php");
} else {
    header("location: ../index.php");
    exit();
}
