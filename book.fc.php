<div id="book-add" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/add_book.bld.php">
        <div class="imgcontainer">
            <h1>Lisää Kirja</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Kirjaa ei luotu!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Kirjaa ei luotu!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "none";
                        echo "<script>window.location.replace('" . siteURL("borrowables")."#". $_GET["name"] . "');</script>";
                        break;
                    default:
                        echo "<div class='login-error'><h2>Kirjaa ei luotu!</h2><p>Järjestelmässä tapahtui virhe. Koodi=" . $_GET["error"] . "</p></div>";
                        break;
                }
            }
            ?>
        </div>

        <div class="container" style="margin-left:">
            <div style="display: inline">
                <label for="book-name"><b>Kirjan Nimi</b></label>
                <input type="text" placeholder="Kirjan nimi..." name="book-name" id="book-name" required>
            </div>
            <div style="display: inline" class="address-container">
                <div style="float: left; width: 39%; margin-right: 1%">
                    <label for="author"><b>Kirjailija</b></label>
                    <input type="text" placeholder="Kirjailija..." name="author" id="author" required>
                </div>
                <div style="float: left; width: 29.5%; margin-right: 1%">
                    <label for="publisher"><b>Julkaisija</b></label>
                    <input type="text" placeholder="Julkaisija..." name="publisher" id="publisher" required>
                </div>
                <div style="float: left; width: 29.5%;">
                    <label for="published"><b>Julkaistu</b></label>
                    <input type="date" max="<?php echo date("Y-m-d");?>" name="published" id="published" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-left: 1px">
                    <label for="language"><b>Kieli</b></label>
                    <select id="language" name="language">
                        <option value="Suomi" selected>Suomi</option>
                        <option value="Finglish">Finglish</option>
                        <option value="English">English</option>
                        <option value="Svenska">Svenska</option>
                        <option value="Other">Muu</option>
                    </select>

                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="isbn"><b>ISBN</b></label>
                    <input type="text" placeholder="ISBN..." name="isbn" id="isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <label for="description">Kuvaus</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <button type="submit" name="submit">Lisää Kirja</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearLoginSignup()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>

