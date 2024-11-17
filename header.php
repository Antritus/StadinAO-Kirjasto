<?php
include_once "init.php";
include_once "build/functions.bld.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/signin.css">
    <link rel="stylesheet" type="text/css" href="css/width.css">
    <?php
        $styles = requiredStyles();
        for ($i = 0; $i < sizeof($styles); $i++){
            echo "<link rel='stylesheet' type='text/css' href='$styles[$i]'>";
        }
    ?>
    <script src="javascript/animated_text.js"></script>
    <script src="javascript/popups/signin.js"></script>
    <script src="javascript/menu.js"></script>
    <?php
    $scripts = requiredScripts();
    for ($i = 0; $i < sizeof($scripts); $i++){
        echo "<script src='$scripts[$i]'></script>";
    }
    ?>

    <title>Kirjasto</title>
</head>
<body>



<?php

$LOGGED_IN = isset($_SESSION["email"]);
$LIBRARIAN_BACKEND_WORKER = false;
$LIBRARIAN_SERVICE_WORKER = false;

global $ADMINISTRATOR, $LIBRARIAN_BACKEND_WORKER, $LIBRARIAN_SERVICE_WORKER, $LOGGED_IN;
?>
<header>
    <nav class="menu">
        <a href="<?php siteURL("borrow") ?>">
            <div class="menu-left">Lainaa</div>
        </a>
        <div class="menu-left">
            <!-- <i class="fa-regular fa-caret-down"></i> --!>
            <span>Varaa <span class="open-status"><i class="fa-solid fa-caret-right"></i></span></span>
            <div class="submenu">
                <a href="<?php siteURL("reserve/book")?>"><div>Kirja</div></a>
                <a href="<?php siteURL("reserve/room")?>"><div>Huone</div></a>
                <a href="<?php siteURL("reserve/item")?>"><div>Työkalu / Väline</div></a>
                <a href="<?php siteURL("reserve/movie")?>"><div>Elokuva</div></a>
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
                echo "
<div class='menu-right menu-account'>
    <span>
        <i class='fa fa-user' style='font-size:25px'></i> 
        <span class='open-status'><i class='fa-solid fa-caret-right'></i></span>
    </span>
    <div class='submenu'>
        <a href=''>TEKSTIÄ TEKSTIÄ</a>
        <form method='post' action='/build/signout.bld.php'>
            <button type='submit' class='menu-item'>Kirjaudu Ulos</button>
        </form>
    </div>
</div>
                    ";

                if ($_SESSION["permission"] >= 5) {
                    echo "<a class='menu-right' href='edit_accounts.php'>Muokka Tilejä</a>";
                    echo "<a class='menu-right' href='books.php'>Muokka Kirjoja</a>";
                }
            }
        ?>
    </nav>
</header>


<?php

if (!$LOGGED_IN) {
    include_once "signin.php";
    include_once "signin-reset-password.php";
    include_once "signup.php";

    if (isset($_GET["signup"]) && !$_GET["signup"] != "none") {
        echo "<script>signup()</script>";
    } else if (isset($_GET["password_reset"]) && !$_GET["password_reset"] != "none") {
        echo "<script>signinResetPassword()</script>";
    } else if (isset($_GET["signin"]) && !$_GET["signin"] != "none") {
        echo "<script>signin()</script>";
    }
}

?>

<script>
    submenus();
</script>
<?php
