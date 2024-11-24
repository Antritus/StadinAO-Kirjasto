<div id="add-book" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/book.add.bld.php">
        <input readonly hidden name="return" id="return" value="item.php">
        <div class="imgcontainer">
            <h1>Lisää Kopio</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Kirjaa ei lisätty!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Kirjaa ei lisätty!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "isbn_already_exists":
                        echo "<div class='login-error'><h2>Kirjaa ei lisätty!</h2><p>Järjestelmässä on jo kirja annetulla (tuote) isbn koodilla!</p></div>";
                        break;
                    case "none";
                        break;
                    default:
                        echo "<div class='login-error'><h2>Kirjan lainausta ei pidennetty!</h2><p>Järjestelmässä tapahtui virhe. Koodi=" . $_GET["error"] . "</p></div>";
                        break;
                }
            }
            ?>
        </div>

        <div class="container">
            <div style="display: inline">
                <label for="add-book-name"><b>Nimi</b></label>
                <input readonly type="text" placeholder="Nimi..." name="add-book-name" id="add-book-name" required>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-right: 1%">
                    <label for="add-isbn"><b>ISBN</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="add-isbn" id="add-isbn" required>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="add-isbn-book"><b>ISBN (Esine)</b></label>
                    <input type="text" placeholder="ISBN..." name="add-isbn-book" id="add-isbn-book" required>
                </div>
            </div>
            <div style="display: inline">
                <label for="add-description"></label>
                <textarea name="add-description" id="add-description" placeholder="Extra tietoa..."></textarea>
            </div>
            <button type="submit" name="submit">Lisää Kopio</button>
        </div>
        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearAdd()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>
