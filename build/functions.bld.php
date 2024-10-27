<?php

$WEB_PORT = 0000;
$WEB_URL = "http://tietokanta.dy.fi/" . $WEB_PORT . "/lantton/kirjasto/";
function siteURL($direction)
{
    global $WEB_URL;
    return $WEB_URL . $direction . ".php";

}
