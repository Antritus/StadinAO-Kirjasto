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
    $name = $_POST["add-book-name"];
    $description = $_POST["add-description"];
    $published = $_POST["add-published"];
    $publisher = $_POST["add-publisher"];
    $language = $_POST["add-language"];
    $category = $_POST["add-category"];
    $return = $_POST["return"];

    require_once "dbh.inc.php";
    require_once "functions.bld.php";

    if (anyFieldsEmpty($name, $category, $publisher, $published, $language, $isbn, $description)) {
        header("location: ../$return?error=field_empty");
        exit();
    }

    $permission = getPermission($conn, $_SESSION["id"]);
    if ($permission < 5){ // No permission
        header("location: ../index.php");
        exit();
    }

    createItem($conn, $isbn, $name, $description, $published, $publisher, $category, $language);
    header("location: ../$return");
} else {
    header("location: ../index.php");
    exit();
}
