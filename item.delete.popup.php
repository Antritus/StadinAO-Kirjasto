<div id="delete-book" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/book.delete.bld.php">
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
            <div style="display: inline;">
                <div style="display: inline">
                    <div style="float: left; width: 49.5%; margin-right: 1%">
                        <label for="delete-isbn"><b>ISBN</b></label>
                        <input readonly type="text" placeholder="ISBN..." name="delete-isbn" id="delete-isbn" required>
                    </div>
                    <div style="float: right; width: 49.5%;">
                        <label for="delete-isbn-book"><b>ISBN (Esine)</b></label>
                        <input readonly type="text" placeholder="ISBN..." name="delete-isbn-book" id="delete-isbn-book" required>
                    </div>
                </div>
            </div>
            <div style="display: inline">
                <label for="delete-description"></label>
                <textarea readonly name="delete-description" id="delete-description" placeholder="Extra tietoa..."></textarea>
            </div>
            <button type="submit" name="submit">Poista Kopio</button>
        </div>
        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearDelete()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>
