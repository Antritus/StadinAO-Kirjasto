<div id="add-book" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/items.add.bld.php">
        <input readonly hidden name="return" id="return" value="items.php">
        <div class="imgcontainer">
            <h1>Lisää Esine</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Kirjaa ei lisätty!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Kirjaa ei lisätty!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "none";
                        echo "<script>window.location.replace('" . siteURL("books")."#". $_GET["name"] . "');</script>";
                        break;
                    default:
                        echo "<div class='login-error'><h2>Kirjaa ei poistettu!</h2><p>Järjestelmässä tapahtui virhe. Koodi=" . $_GET["error"] . "</p></div>";
                        break;
                }
            }
            ?>
        </div>

        <div class="container" style="margin-left:">
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-right: 1%">
                    <label for="add-book-name">Esineen Nimi</label>
                    <input type="text" placeholder="Esineen nimi..." name="add-book-name" id="add-book-name" required>
                </div>
                <div style="float: left; width: 49.5%;">
                    <label for="add-category">Kategoria</label>
                    <select id="add-category" name="add-category">
                        <option value="Tools" selected>Työkalut</option>
                        <option value="Home">Koti</option>
                        <option value="Players">Soitin (Laite)</option>
                        <option value="Library">Kirjasto Palvelu</option>
                        <option value="Other">Muu</option>
                    </select>
                </div>

            </div>
            <div style="display: inline" class="address-container">
                <div style="float: left; width: 49.5%; margin-right: 1%">
                    <label for="add-publisher">Merkki</label>
                    <input type="text" placeholder="Merkki..." name="add-publisher" id="add-publisher" required>
                </div>
                <div style="float: left; width: 49.5%;">
                    <label for="add-published">Vuosimalli</label>
                    <input type="date" max="<?php echo date("Y-m-d");?>" name="add-published" id="add-published" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-left: 1px">
                    <label for="add-language">Kieli</label>
                    <select id="add-language" name="add-language">
                        <option value="Suomi" selected>Suomi</option>
                        <option value="Finglish">Finglish</option>
                        <option value="English">English</option>
                        <option value="Svenska">Svenska</option>
                        <option value="Other">Muu</option>
                    </select>

                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="add-isbn">ISBN</label>
                    <input type="text" placeholder="ISBN..." name="add-isbn" id="add-isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <label for="add-description">Kuvaus</label>
                <textarea id="add-description" name="add-description"></textarea>
            </div>
            <button type="submit" name="submit">Lisää Esine</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearBookAdd()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>

