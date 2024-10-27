<?php
include "build/functions.bld.php"
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/signin.css">
    <link rel="stylesheet" type="text/css" href="css/width.css">
    <script src="javascript/animated_text.js"></script>
    <script src="javascript/signin.js"></script>

    <title>Kirjasto</title>
</head>
<body>


<?php

$LOGGED_IN = false;
$ADMINISTRATOR = false; /* TODO */
$LIBRARIAN_BACKEND_WORKER = false;
$LIBRARIAN_SERVICE_WORKER = false;

global $ADMINISTRATOR, $LIBRARIAN_BACKEND_WORKER, $LIBRARIAN_SERVICE_WORKER, $LOGGED_IN;
?>
<header>
    <nav class="menu">
        <a href="<?php siteURL("borrow") ?>">
            <div class="menu-left">Lainaa</div>
        </a>
        <div href="<?php siteURL("reserve_item") ?>">
            <div class="menu-left">
                <span onclick="console.log('A');" id="submenu-dropdown"><a>Varaa</a></span>
                <div class="submenu">
                    <a href="<?php siteURL("reserve/book")?>"><div>Kirja</div></a>
                    <a href="<?php siteURL("reserve/room")?>"><div>Huone</div></a>
                    <a href="<?php siteURL("reserve/item")?>"><div>Työkalu / Väline</div></a>
                    <a href="<?php siteURL("reserve/movie")?>"><div>Elokuva</div></a>
                </div>
            </div>
        </div>

        <a href="<?php siteURL("return") ?>">
            <div class="menu-left">Palauta</div>
        </a>
        <a href="<?php siteURL("wish_box") ?>">
            <div class="menu-left">Toivelaatikko</div>
        </a>

        <?php
            if (!$LOGGED_IN){
                echo "
                <div class='menu-right' onclick='signin()'>Kirjaudu Sisään</div>
                <div class='menu-right' onclick='signup()'>Luo Käyttäjätili</div>
                ";
            } else {
                echo "<div class='menu-right menu-account'><i class='fa fa-user' style='font-size:25px'></i></div>";
            }
        ?>

        <?php
        if ($ADMINISTRATOR){
            echo "

<div class='menu-right administrator'>    
Admin
<div class='submenu' id='submenu-admin'>
    <a href='" . siteURL("admin/manage_employees") ."'><div>Muokkaa Työntekijöitä</div></a>
    <a href='" . siteURL("admin/manage_customers") . "'><div>Muokkaa käyttäjiä</div></a>
    <a href='" . siteURL("keeper/manage_books") . "'><div>Muokkaa Kirjoja</div></a>
    <a href='" . siteURL("keeper/manage_items") . "'><div>Muokkaa Vuokrattavia</div></a>
    <a href='" . siteURL("keeper/manage_rooms") . "'><div>Muokkaa Työhuoneita</div></a>
    <a href='" . siteURL("keeper/see_requests") . "'><div>Katso toivelaatikkoa</div></a>
    <a href='" . siteURL("librarian/reserve_books") . "'><div>Varaa kirja</div></a>
    <a href='" . siteURL("librarian/reserve_tools") . "'><div>Varaa tavara</div></a>
    <a href='" . siteURL("librarian/reserve_rooms") . "'><div>Varaa huone</div></a>
    <a href='" . siteURL("librarian/add_customer_request") . "'><div>Lisää asiakas toive</div></a>
</div>
</div>

                    ";
        } else if ($LIBRARIAN_BACKEND_WORKER){
            echo "
<a>
<div class='menu-right backend'>
Hoitaja
<div class='submenu' id='submenu-backend'>
<a href='" . siteURL("librarian/manage_books") . "'><div>Muokkaa Kirjoja</div></a>
<a href='" . siteURL("librarian/manage_items") . "'><div>Muokkaa Vuokrattavia</div></a>
<a href='" . siteURL("librarian/manage_rooms") . "'><div>Muokkaa Työhuoneita</div></a>
<a href='" . siteURL("librarian/item_status") . "'><div>Katso saatavuuus</div></a>
<a href='" . siteURL("librarian/see_requests") . "'><div>Katso toivelaatikkoa</div></a>";
            if ($LIBRARIAN_SERVICE_WORKER){
                echo "
<a href='" . siteURL("librarian/reserve_books") . "'><div>Varaa kirja</div></a>
<a href='" . siteURL("librarian/reserve_tools") . "'><div>Varaa tavara</div></a>
<a href='" . siteURL("librarian/reserve_rooms") . "'><div>Varaa huone</div></a>
<a href='" . siteURL("librarian/add_customer_request") . "'><div>Lisää asiakas toive</div></a>
";
            }
            echo "
</div>
</div>
</a>
                    ";
        } else if ($LIBRARIAN_SERVICE_WORKER){
            echo "
<a>
<div class='menu-right service-desk'>    
Hoitaja
<div class='submenu' id='submenu-service'>
<a href='" . siteURL("librarian/reserve_books") . "'><div>Varaa kirja</div></a>
<a href='" . siteURL("librarian/reserve_tools") . "'><div>Varaa tavara</div></a>
<a href='" . siteURL("librarian/reserve_rooms") . "'><div>Varaa huone</div></a>
<a href='" . siteURL("librarian/add_customer_request") . "'><div>Lisää asiakas toive</div></a>
<a href='" . siteURL("librarian/item_status") . "'><div>Katso saatavuuus</div></a>

</div>
</div>
</a>
                    ";
        }
        ?>
    </nav>
</header>


<?php
include_once "signin.php";
include_once "signin-reset-password.php";
include_once "signup.php";
?>