<div id="extend-book" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/book.extend.bld.php">
        <div class="imgcontainer">
            <h1>Pidennä Lainausta</h1>


            <?php

            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>Kirjan lainausta ei pidennetty!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>Kirjan lainausta ei pidennetty!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "book_is_not_borrowed":
                        echo "<div class='login-error'><h2>Kirjan lainausta ei pidennetty!</h2><p>Kirjaa ei ole lainattu</p></div>";
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
                <label for="extend-book-name"><b>Kirja</b></label>
                <input readonly type="text" placeholder="Kirjan nimi..." name="extend-book-name" id="extend-book-name" required>
            </div>
            <div style="display: inline">
                <div style="width: 49.5%; float: left">
                    <label for="extend-isbn"><b>ISBN</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="extend-isbn" id="extend-isbn" required>
                </div>
                <div style="width: 49.5%; margin-left: 1%; float: right">
                    <label for="extend-book-isbn"><b>ISBN (Kirja)</b></label>
                    <input readonly type="text" placeholder="ISBN..." name="extend-book-isbn" id="extend-book-isbn" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%;">
                    <label for="extend-account"><b>Käyttäjä</b></label>
                    <input readonly type="text" placeholder="Käyttäjä Id..." name="extend-account" id="extend-account" required>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="extend-return_date"><b>Viimeinen Palautus Päivä</b></label>
                    <input type="date" value="<?php echo dateFromNow("+1 months") ?>" min="<?php echo dateFromNow("+1 months"); ?>" max="<?php echo dateFromNow("+3 months"); ?>" name="extend-return_date" id="extend-return_date" required>
                </div>
            </div>
            <button type="submit" name="submit">Pidennä Lainausta</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearExtend()" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>


<?php
if (isset($_GET["error"]) && $_GET["error"] == "book_is_not_borrowed"){
    global $conn;
    $book = getBook($conn, $_GET["isbn"]);
    $item = getItem($conn, $book, $_GET["bookIsbn"]);

    echo "<script>".js("bookBorrow", $item["id"], $book["isbn"], $book["name"], $item["borrowed"])."</script>";
}