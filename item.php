<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
//requireStyle("../css/userstable.css");
requireStyle("../css/bookinfo.css");
requireStyle("../css/bookstable.css");
requireScript("../javascript/popups/book.js");


if (!isset($_GET["isbn"])){
    header("location: items.php");
}

if ($_SESSION["permission"] < 5){
    header("location: index.php?no_permissions=2");
    exit();
}

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";
global $conn;

$isbn = $_GET["isbn"];
$book = getBook($conn, $isbn);

$bookInventory = getInventory($conn, $isbn);

function permission($permission): bool
{
    if ($_SESSION["permission"]>=($permission)) {
        return true;
    }
    return false;
}

function echoIfPermission($permission, $echo) {
    if ($_SESSION["permission"]>=($permission)){
        return $echo;
    }
    return "";
}
function echoIfNoPermission($permission, $echo) {
    if ($_SESSION["permission"]<($permission)){
        return $echo;
    }
    return "";
}

function valueOrDash($value)
{
    if (!isset($value) || $value==null){
        return "-";
    }
    return $value;
}
function borrowed($borrowed)
{
    if (isset($borrowed) && $borrowed != null){
        return "<span class='borrowed-true'>Kyllä</span>";
    } else {
        return "<span class='borrowed-false'>Ei</span>";
    }
}


/**
 * @throws DateMalformedStringException
 */
function pastLicense($expire){
    if ($expire==null){
        return "-";
    }
    $date = new DateTime();
    $dateExpired = new DateTime($expire);

    if ($date > $dateExpired){
        return borrowed(true);
    }
    return borrowed(null);
}
/**
 * @throws DateMalformedStringException
 */
function isPastLicense($expire){
    if ($expire==null){
        return false;
    }
    $date = new DateTime();
    $dateExpired = new DateTime($expire);

    return ($date > $dateExpired);
}

include_once "header.php";
?>

                <div class="alignment">
                    <div class="col-left"></div>
                    <div class="book-container">
                        <div class="item-path">
                            <span class="item-path"><a href="items.php">Tavarat</a> > <a href="item.php?isbn=<?php echo $isbn; ?>"><?php echo $book["name"]; ?></a></span>
                            <!--
                            <form method="post" action="books.delete.popup.php">
                                <input hidden name='delete-isbn' value='<?php echo $isbn; ?>' id='delete-isbn'>
                                <button type="submit"></button>
                            </form>
                            <button></button>
                            --!>
                        </div>
                        <div class="book-header">
                                <form class="modal-content animate" method="post" action="build/book.borrow.bld.php">
                                    <div class="imgcontainer">
                                        <h1><?php echo $book["name"];?></h1>
                                    </div>

                                    <div class="container">
                                        <div style="display: inline">
                                            <div style="width: 49.5%; float: left; margin-right: 1%">
                                                <label for="book-name"><b>Nimi</b></label>
                                                <input type="text" placeholder="Kirjan nimi..." name="book-name" id="book-name" value="<?php echo $book["name"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                            <div style="width: 49.5%; float: right">
                                                <label for="book-publisher"><b>Merkki</b></label>
                                                <input type="text" placeholder="Merkki..." name="book-publisher" id="book-publisher" value="<?php echo $book["publisher"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                        </div>
                                        <div style="display: inline">
                                            <div style="float: left; width: 49.5%;">
                                                <label for="book-language"><b>Kieli</b></label>
                                                <select id="book-language" name="book-language" <?php echo echoIfNoPermission(5, "disabled"); ?>>
                                                    <option value="Suomi" <?php echo ($book["language"]=="Suomi") ? "selected" : "";?>>Suomi</option>
                                                    <option value="Finglish" <?php echo ($book["language"]=="Finglish") ? "selected" : "";?>>Finglish</option>
                                                    <option value="English" <?php echo ($book["language"]=="English") ? "selected" : "";?>>English</option>
                                                    <option value="Svenska" <?php echo ($book["language"]=="Svenska") ? "selected" : "";?>>Svenska</option>
                                                    <option value="Other" <?php echo ($book["language"]=="Other") ? "selected" : "";?>>Muu</option>
                                                </select>
                                            </div>
                                            <div style="float: right; width: 49.5%;">
                                                <label for="book-published"><b>Vuosimalli</b></label>
                                                <input type="date" value="<?php echo dateFromNow("+0 months") ?>" max="<?php echo dateFromNow("+1 days"); ?>" name="book-published" id="book-published" value="<?php echo $book["released"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                        </div>

                                        <div style="display: inline">
                                            <label for="book-description"></label>
                                            <textarea name="book-description" id="book-description" <?php echo echoIfNoPermission(5, "readonly"); ?>><?php echo $book["description"]; ?></textarea>
                                        </div>
                                        <?php
                                            echo echoIfPermission(5,
                                            "<div style='float: right; width: 25%'>
                                                    <button type='submit' name='submit'>Lähetä Muokkaus</button>
                                                 </div>");
                                        ?>
                                    </div>
                                </form>
                            </div>
                        <div class="book-footer modal-content non-form">
                            <div class="imgcontainer">
                                <h1>Lainaukset</h1>
                            </div>
                            <div class="container">
                            <table class="content-table">
                                <thead>
                                <tr>
                                    <th>ISBN</th>
                                    <th>Tietoa</th>
                                    <th>Lainattu</th>
                                    <th>Lainaaja</th>
                                    <th>Lainaus Alkanut</th>
                                    <th>Lainaus Päättyy</th>
                                    <th>Lainaus Ajan Yli</th>
                                    <th class="add-element">
                                        <button name="submit" type="submit" onclick='<?php echo js("addBook", $book["isbn"], $book["name"]) ?>'>Lisää Kopio</button>
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $isbnPaste = htmlspecialchars($isbn, ENT_QUOTES, 'UTF-8');
                                if (isset($bookInventory)) {
                                    for ($i = 0; $i < 100; $i++) {
                                        if (empty($bookInventory[$i])) {
                                            break;
                                        }
                                        $item = $bookInventory[$i];
                                        $id = $item['id'];
                                        echo "
<tr ".(isPastLicense($item["borrow_end"]) ? "class='last-chance'" : "") .">
    <th>" . valueOrDash($id) . "</th>
    <th>" . valueOrDash($item['description']) . "</th>
    <th>" . borrowed($item['borrower']) . "</th>
    <th>" . valueOrDash($item['borrower']) . "</th>
    <th>" . valueOrDash($item['borrow_start']) . "</th>
    <th>" . valueOrDash($item['borrow_end']) . "</th>
    <th>" . pastLicense($item['borrow_end']) . "</th>
    <th class='edit-buttons'>";
                                        if (valueOrDash($item["borrower"]) !== "-") {
                                            if (!isPastLicense($item["borrow_end"])) {
                                                echo echoIfPermission(5, "
                <button class='borrow' type='submit' name='isbn' onclick='".js("extend", $isbn, $id, $book["name"], $item['borrower'])."'>Pidennä Lainausta</button>");
                                                echo echoIfPermission(5,
                                                        "
<button class='return' onclick='".js("bookReturn", $isbn, $item["id"], $book["name"], $item["borrower"], $item["borrow_end"]))."'>Palauta</button>";
                                            } else {
                                                echo echoIfPermission(5,
                                                        "
<button class='return last-chance' onclick='".js("bookReturn", $isbn, $item["id"], $book["name"], $item["borrower"], $item["borrow_end"]))."'>Palauta</button>";

                                            }

                                        } else {
                                            echo echoIfPermission(5,
                                                    "
        <button type='submit' class='return' name='submit' onclick='".js("bookBorrow", $isbn, $item["id"], $book["name"])."'>Lainaa</button>
    ");
                                            echo echoIfPermission(10, "
                                  <button class='delete' type='submit' class='return' name='submit' onclick='" . js("deleteBook", $isbn, $item["id"], $item["description"]) . "'>Poista</button>
                                   ");
                                        }
                                        echo "</th></tr>";
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-right"></div>
                </div>


<?php
include_once "item.return.popup.php";
include_once "item.extend.popup.php";
include_once "item.add.popup.php";
include_once "item.borrow.popup.php";
include_once "item.delete.popup.php";

include_once "footer.php";

