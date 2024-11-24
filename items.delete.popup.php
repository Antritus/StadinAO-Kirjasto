<div id="book-delete" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/books.delete.bld.php">
        <input readonly hidden name="return" id="return" value="items.php">
        <div class="imgcontainer">
            <h1>Poista Esine</h1>


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
                    <label for="delete-book-name">Esineen Nimi</label>
                    <input readonly type="text" placeholder="Esineen nimi..." name="delete-book-name" id="delete-book-name" required>
                </div>
                <div style="float: left; width: 49.5%;">
                    <label for="delete-category">Kategoria</label>
                    <select disabled id="delete-language" name="delete-language">
                        <option value="Tools" selected>Työkalut</option>
                        <option value="Home">Koti</option>
                        <option value="Players">Soitin (Laite)</option>
                        <option value="Other">Muu</option>
                    </select>
                </div>

            </div>
            <div style="display: inline" class="address-container">
                <div style="float: left; width: 49.5%; margin-right: 1%">
                    <label for="delete-publisher">Merkki</label>
                    <input readonly type="text" placeholder="Merkki..." name="delete-publisher" id="delete-publisher" required>
                </div>
                <div style="float: left; width: 49.5%;">
                    <label for="delete-published">Vuosimalli</label>
                    <input readonly type="date" max="<?php echo date("Y-m-d");?>" name="delete-published" id="delete-published" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-left: 1px">
                    <label for="delete-language">Kieli</label>
                    <select disabled id="delete-language" name="delete-language">
                        <option value="Suomi" selected>Suomi</option>
                        <option value="Finglish">Finglish</option>
                        <option value="English">English</option>
                        <option value="Svenska">Svenska</option>
                        <option value="Other">Muu</option>
                    </select>

                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="delete-isbn">ISBN</label>
                    <input readonly type="text" placeholder="ISBN..." name="delete-isbn" id="delete-isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <label for="delete-description">Kuvaus</label>
                <textarea readonly id="delete-description" name="delete-description"></textarea>
            </div>
            <button type="submit" name="submit">Poista Esine</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearBookAdd()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>

