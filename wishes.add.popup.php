<div id="add-wish" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/books.add.bld.php">
        <input readonly hidden name="return" id="return" value="wishes.php">
        <div class="imgcontainer">
            <h1>Lisää Toive</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Toivetta ei lisätty!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Toivetta ei lisätty!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "none";
                        echo "<script>window.location.replace('" . siteURL("books")."#". $_GET["name"] . "');</script>";
                        break;
                    default:
                        echo "<div class='login-error'><h2>Toivetta ei poistettu!</h2><p>Järjestelmässä tapahtui virhe. Koodi=" . $_GET["error"] . "</p></div>";
                        break;
                }
            }
            ?>
        </div>

        <div class="container" style="margin-left:">
            <div style="display: inline">
                <label for="add-book-name"><b>Kirjan Nimi</b></label>
                <input type="text" placeholder="Kirjan nimi..." name="add-book-name" id="add-book-name" required>
            </div>
            <div style="display: inline" class="address-container">
                <div style="float: left; width: 39%; margin-right: 1%">
                    <label for="add-author"><b>Kirjailija</b></label>
                    <input type="text" placeholder="Kirjailija..." name="add-author" id="add-author" required>
                </div>
                <div style="float: left; width: 29.5%; margin-right: 1%">
                    <label for="add-publisher"><b>Julkaisija</b></label>
                    <input type="text" placeholder="Julkaisija..." name="add-publisher" id="add-publisher" required>
                </div>
                <div style="float: left; width: 29.5%;">
                    <label for="add-published"><b>Julkaistu</b></label>
                    <input type="date" max="<?php echo date("Y-m-d");?>" name="add-published" id="add-published" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-left: 1px">
                    <label for="add-language"><b>Kieli</b></label>
                    <select id="add-language" name="add-language">
                        <option value="Suomi" selected>Suomi</option>
                        <option value="Finglish">Finglish</option>
                        <option value="English">English</option>
                        <option value="Svenska">Svenska</option>
                        <option value="Other">Muu</option>
                    </select>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="add-isbn"><b>ISBN</b></label>
                    <input type="text" placeholder="ISBN..." name="add-isbn" id="add-isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <label for="add-description">Kuvaus</label>
                <textarea id="add-description" name="add-description"></textarea>
            </div>
            <button type="submit" name="submit">Lisää Toive</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="closeBookAdd()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>

