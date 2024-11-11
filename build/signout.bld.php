<?php

session_start();
session_unset();
session_destroy();
session_start();

if (isset($_GET["login"])){
    header("location index.php?login=".$_GET["login"]);
    exit();
}

header("location: index.php");
exit();