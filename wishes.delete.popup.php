<div id="wish-delete" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/books.delete.bld.php">
        <input readonly hidden name="return" id="return" value="wishes.php">
        <div class="imgcontainer">
            <h1>Poista Toive Järjestelmästä</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Kirjaa ei poistettu!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Kirjaa ei poistettu!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
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
                <label for="delete-book-name"><b>Kirjan Nimi</b></label>
                <input readonly type="text" placeholder="Kirjan nimi..." name="delete-book-name" id="delete-book-name" required>
            </div>
            <div style="display: inline" class="address-container">
                <div style="float: left; width: 39%; margin-right: 1%">
                    <label for="delete-author"><b>Kirjailija</b></label>
                    <input readonly type="text" placeholder="Kirjailija..." name="delete-author" id="delete-author" required>
                </div>
                <div style="float: left; width: 29.5%; margin-right: 1%">
                    <label for="delete-publisher"><b>Julkaisija</b></label>
                    <input readonly type="text" placeholder="Julkaisija..." name="delete-publisher" id="delete-publisher" required>
                </div>
                <div style="float: left; width: 29.5%;">
                    <label for="delete-published"><b>Julkaistu</b></label>
                    <input readonly type="date" max="<?php echo date("Y-m-d");?>" name="delete-published" id="delete-published" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-left: 1px">
                    <label for="delete-language"><b>Kieli</b></label>
                    <select disabled id="delete-language" name="delete-language">
                        <option value="Suomi" selected>Suomi</option>
                        <option value="Finglish">Finglish</option>
                        <option value="English">English</option>
                        <option value="Svenska">Svenska</option>
                        <option value="Other">Muu</option>
                    </select>

                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="delete-isbn"><b>ISBN</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="delete-isbn" id="delete-isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <label for="delete-description">Kuvaus</label>
                <textarea readonly id="delete-description" name="delete-description"></textarea>
            </div>
            <button type="submit" name="submit" class="cancel-red">Poista Kirja</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="closeBookDelete()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>

