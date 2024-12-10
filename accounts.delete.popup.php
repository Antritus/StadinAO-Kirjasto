<div id="account-delete" class="modal login-screen">
    <form id="account-delete-form" class="modal-content animate" method="post" action="build/accounts.delete.bld.php">
        <input readonly hidden name="return" id="return" value="accounts.php">
        <div class="imgcontainer">
            <h1>Poista Tili</h1>


            <?php

            if (isset($_GET["signup"])) {
                switch ($_GET["signup"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Käyttäjätiliä ei luotu!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "invalid_email";
                        echo "<div class='login-error'><h2>Käyttäjätiliä ei luotu!</h2><p'>Annettu sähköposti on virheellinen</p></div>";
                        break;
                    case "passwords_dont_match";
                        echo "<div class='login-error'><h2>Käyttäjätiliä ei luotu!</h2><p>Annetut salasanat eivät täsmää</p></div>";
                        break;
                    case "email_already_exists";
                        echo "<div class='login-error'><h2>Käyttäjätiliä ei luotu!</h2><p>Annettu sähköposti on jo käytössä</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Käyttäjätiliä ei luotu!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "true":
                        break;
                    case "none";
                        echo "<script>window.location.replace('" . siteURL("index") . "');</script>";
                        break;
                    default:
                        echo "<div class='login-error'><h2>Käyttäjätiliä ei luotu!</h2><p>Järjestelmässä tapahtui virhe. Koodi=" . $_GET["signin"] . "</p></div>";
                        break;
                }
            }
            ?>
        </div>

        <div class="container" style="margin-left:">
            <div style="display: inline">
                <div style="float: left; width: 19.5%;">
                    <label for="delete-id"><b>Id</b></label>
                    <input type="text" placeholder="Id..." name="delete-id" id="delete-id" required readonly>
                </div>
                <div style="float: left; width: 59.5%; margin-left: 0.5%">
                    <label for="delete-email"><b>Sähköposti</b></label>
                    <input type="email" placeholder="Sähköposti..." name="delete-email" id="delete-email" required readonly>
                </div>
                <div style="float: right; width: 19.5%; margin-left: 0.5%">
                    <label for="delete-acc-name"><b>Tili nimi</b></label>
                    <input type="email" placeholder="Tili nimi..." name="delete-acc-name" id="delete-acc-name" required readonly>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-right: 1%">
                    <label for="name"><b>Etunimi</b></label>
                    <input type="text" placeholder="Etunimi..." name="delete-name" id="delete-name" required readonly>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="sname"><b>Sukunimi</b></label>
                    <input type="text" placeholder="Sukunimi..." name="delete-sname" id="delete-sname" required readonly>
                </div>
            </div>
            <div style="display: inline" class="address-container">
                <div style="float: left; width: 39%; margin-right: 1%">
                    <label for="address"><b>Osoite</b></label>
                    <input type="text" placeholder="Osoite..." name="delete-address" id="delete-address" required readonly>
                </div>
                <div style="float: left; width: 29.5%; margin-right: 1%">
                    <label for="postcode"><b>Postinumero</b></label>
                    <input type="text" placeholder="Postinumero..." name="delete-postcode" id="delete-postcode" required  readonly>
                </div>
                <div style="float: left; width: 29.5%;">
                    <label for="postarea"><b>Postitoimialue</b></label>
                    <select id="country" name="delete-postarea" id="delete-postarea" disabled>
                        <option value="Espoo">Espoo</option>
                        <option value="Helsinki" selected>Helsinki</option>
                        <option value="Vantaa">Vantaa</option>
                    </select>
                </div>
                <div style="float: right; width: 34.5%;">
                    <label for="birthdate"><b>Syntymäaika</b></label>
                    <input type="date" min="<?php echo (date("Y")-100) . "-" . (date("m-d"));?>" max="<?php echo date("Y-m-d");?>" name="delete-birthdate" id="delete-birthdate" required readonly>
                </div>
            </div>
            <button type="submit" name="submit">Poista Käyttäjä</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="closeAccountDelete()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>

