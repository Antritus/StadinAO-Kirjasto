<?php
session_start();

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";

global $conn;

$requiredStyles = [];
$styles = 0;
$requiredScripts = [];
$scripts = 0;

function requireStyle($path){
    global $styles, $requiredStyles;
    $requiredStyles[$styles] = $path;
    $styles++;
}

function requiredStyles() : array
{
    global $requiredStyles;
    return $requiredStyles;
}

function requireScript($path){
    global $scripts, $requiredScripts;
    $requiredScripts[$scripts] = $path;
    $scripts++;
}

function requiredScripts(): array
{
    global $requiredScripts;
    return  $requiredScripts;
}