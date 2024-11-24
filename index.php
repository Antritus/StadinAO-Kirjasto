<?php
include_once "init.php";

if (isset($_SESSION["id"])){
    header("location: edit_accounts.php");
    exit();
}

include_once "header.php";





?>







<?php
include_once "footer.php";

