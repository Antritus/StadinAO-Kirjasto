<?php
include "global_functions.php";
include "user_account.php";

global $ADMINISTRATOR, $LIBRARIAN_BACKEND_WORKER, $LIBRARIAN_SERVICE_WORKER, $LOGGED_IN;
?>
<header>
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

     <div class="menu-right menu-account" <?php
        if (!$LOGGED_IN) {
            echo "onclick=\"document.getElementById('login-screen').style.display='block'\"";
        }
     ?>><i class="fa fa-user" style="font-size:25px"></i></div>

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

     <div class="menu-right menu-search">
         <form>
                     <input type="text" name="searching_for" placeholder="<?php
                     $CATEGORY = [
                         "Kirjan nimi", "Kirjailija", "Vuosi luku", "Tyylilaji",
                         "ISBN (Tuote koodi)", "Työkalu", "Väline", "Harrastus",
                         "Eläin", "Lehti", "Artisti", "Soitin", "Henkilö"];
                     $CHOSEN = $CATEGORY[rand(0, sizeof($CATEGORY)-1)];
                     echo $CHOSEN;
                     ?>...">
                 <button type="submit"><i class="fa fa-search" style="font-size:14px"></i> Etsi</button>
         </form>
     </div>
    </nav>
</header>

<div id="login-screen" class="modal login-screen">
  <span onclick="document.getElementById('login-screen').style.display='none'"
        class="close" title="Close Modal">&times;</span>

    <!-- Modal Content -->
    <form class="modal-content animate" action="/action_page.php">
        <div class="imgcontainer">
            <img src="https://cdn.prod.website-files.com/62bdc93e9cccfb43e155104c/63c3b5871a14151846293c4d_Funny%20Cat%20Pfp%20for%20Tiktok%201.jpg" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="username"><b>Käyttäjä</b></label>
            <input type="text" placeholder="Käyttäjänimi" name="username" required>

            <label for="password"><b>Salasana</b></label>
            <input type="password" placeholder="Salasana" name="password" required>

            <button type="submit">Kirjaudu</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Muista Minut
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('login-screen').style.display='none'" class="cancelbtn">Cancel</button>
            <span class="psw">Unohditko <a href="#">salasanasi?</a></span>
        </div>
    </form>
</div>

<script>
    // Get the modal
    var modal = document.getElementById('login-screen');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>