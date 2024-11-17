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

function js($function, ...$params) {
    $fn = $function . "(";
    $first = true;
    foreach ($params as $param) {
        if (!$first) {
            $fn .= ",";
        }
        $fn .= "\"".$param."\"";
        $first = false;
    }
    return $fn . ")";
}

function dateFromNow($add) : string{
    $dateReal = new DateTime();
    $dateReal->modify($add);
    return $dateReal->format("Y-m-d");
}