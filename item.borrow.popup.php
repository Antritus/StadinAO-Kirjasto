<div id="borrow-book" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/book.borrow.bld.php">
        <input readonly hidden name="return" id="return" value="item.php">
        <div class="imgcontainer">
            <h1>Esineen Lainaus</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Ei voitu lainata kirjaa!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Ei voitu lainata kirjaa!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "book_is_borrowed":
                        echo "<div class='login-error'><h2>Ei voitu lainata kirjaa!</h2><p>Kirja on jo lainattu!</p></div>";
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
                <label for="borrow-book-name"><b>Nimi</b></label>
                <input readonly type="text" placeholder="Nimi..." name="borrow-book-name" id="borrow-book-name" required>
            </div>
            <div style="display: inline">
                <div style="width: 49.5%; float: left">
                    <label for="borrow-isbn"><b>ISBN</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="borrow-isbn" id="borrow-isbn" required>
                </div>
                <div style="width: 49.5%; margin-left: 1%; float: right">
                    <label for="borrow-book-isbn"><b>ISBN (Esine)</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="borrow-book-isbn" id="borrow-book-isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%;">
                    <label for="borrow-account"><b>Käyttäjä</b></label>
                    <input type="text" placeholder="Käyttäjä Id..." name="borrow-account" id="borrow-account" required>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="borrow-return_date"><b>Viimeinen Palautus Päivä</b></label>
                    <input type="date" value="<?php echo dateFromNow("+1 months") ?>" min="<?php echo dateFromNow("+1 months"); ?>" max="<?php echo dateFromNow("+3 months"); ?>" name="borrow-return_date" id="borrow-return_date" required>
                </div>
            </div>
            <button type="submit" name="submit">Lainaa Kirja</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearBorrow()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>
