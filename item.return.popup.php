<div id="return-book" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/book.return.bld.php">
        <input readonly hidden name="return" id="return" value="item.php">
        <div class="imgcontainer">
            <h1>Palauta Kirja</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Ei voitu palauttaa kirjaa!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Ei voitu palauttaa kirjaa!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "book_is_not_borrowed":
                        echo "<div class='login-error'><h2>Ei voitu palauttaa kirjaa!</h2><p>Kirja on jo palautettu!</p></div>";
                        break;
                    case "none";
                        break;
                    default:
                        echo "<div class='login-error'><h2>Ei voitu palauttaa kirjaa!</h2><p>Järjestelmässä tapahtui virhe. Koodi=" . $_GET["error"] . "</p></div>";
                        break;
                }
            }
            ?>
        </div>

        <div class="container">
            <div style="display: inline">
                <label for="return-book-name"><b>Esineen Nimi</b></label>
                <input readonly type="text" placeholder="Kirjan nimi..." name="return-book-name" id="return-book-name" required>
            </div>
            <div style="display: inline">
                <div style="width: 49.5%; float: left">
                    <label for="return-isbn"><b>ISBN</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="return-isbn" id="return-isbn" required>
                </div>
                <div style="width: 49.5%; margin-left: 1%; float: right">
                    <label for="return-book-isbn"><b>ISBN (Kirja)</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="return-book-isbn" id="return-book-isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%;">
                    <label for="return-account"><b>Käyttäjä</b></label>
                    <input readonly type="text" placeholder="Käyttäjä Id..." name="return-account" id="return-account" required>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="return-return_date"><b>Viimeinen Palautus Päivä</b></label>
                    <input readonly type="date" value="" min="<?php echo dateFromNow("+1 months"); ?>" max="<?php echo dateFromNow("+3 months"); ?>" name="return-return_date" id="return-return_date" required>
                </div>
            </div>
            <button type="submit" name="submit">Palauta Kirja</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearReturn()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>
