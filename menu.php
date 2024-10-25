<?php
include "global_functions.php";

global $ADMINISTRATOR, $LIBRARIAN_BACKEND_WORKER, $LIBRARIAN_SERVICE_WORKER;
?>

    <link rel="stylesheet" type="text/css" href="menu.css">
    <script language="javascipt" src="javascript/animated_text.js"></script>
    <nav class="menu">
        <a href="<?php siteURL("index") ?>">
            <div class="menu-left menu-logo">Kirjasto</div>
        </a>
        <a href="<?php siteURL("borrow") ?>">
            <div class="menu-left">Lainaa</div>
        </a>
        <a href="<?php siteURL("reserve_item") ?>">
            <div class="menu-left">
                <span id="submenu-dropdown">Varaa</span>
                <div class="submenu">
                    <a href="<?php siteURL("reserve/book")?>"><div>Kirja</div></a>
                    <a href="<?php siteURL("reserve/room")?>"><div>Huone</div></a>
                    <a href="<?php siteURL("reserve/item")?>"><div>Työkalu / Väline</div></a>
                    <a href="<?php siteURL("reserve/movie")?>"><div>Elokuva</div></a>
                </div>
            </div>
        </a>

        <a href="<?php siteURL("return") ?>">
            <div class="menu-left">Palauta</div>
        </a>
        <a href="<?php siteURL("wish_box") ?>">
            <div class="menu-left">Toivelaatikko</div>
        </a>

        <div class="menu-right menu-search">
            <form>
                <label>
                    <label>
                        <input type="text" name="searching_for" placeholder="<?php
                        $CATEGORY = [
                            "Kirjan nimi", "Kirjailija", "Vuosi luku", "Tyylilaji",
                            "ISBN (Tuote koodi)", "Työkalu", "Väline", "Harrastus",
                            "Eläin", "Lehti", "Artisti", "Soitin", "Henkilö"];
                        $CHOSEN = $CATEGORY[rand(0, sizeof($CATEGORY)-1)];
                        echo $CHOSEN;
                        ?>...">
                    </label>
                    <button type="submit"><i class="fa fa-search" style="font-size:14px"></i> Etsi</button>
                </label>
            </form>
        </div>
        <a href="<?php siteURL("käyttäjä") ?>">
            <div class="menu-right menu-account"><i class="fa fa-user" style="font-size:25px"></i></div>
        </a>

        <?php
        if ($ADMINISTRATOR){
            echo "
<a>
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
</a>
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