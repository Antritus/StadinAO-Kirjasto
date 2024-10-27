<?php

$dbHost = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "stadinaolibrary";

$conn = mysqli_connect($dbHost, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed " . mysqli_connect_error());
}