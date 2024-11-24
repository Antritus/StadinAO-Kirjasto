<?php
include_once "init.php";

if (isset($_SESSION["id"])){
    header("location: books.php");
    exit();
}

include_once "header.php";





?>







<?php
include_once "footer.php";

