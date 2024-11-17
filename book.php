<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
//requireStyle("../css/userstable.css");
requireStyle("../css/bookinfo.css");
requireStyle("../css/bookstable.css");
requireScript("../javascript/popups/book.js");


if (!isset($_GET["isbn"])){
    header("location: books.php");
}

if ($_SESSION["permission"] < 5){
    header("location: index.php?no_permissions=2");
    exit();
}

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";
global $conn;

$isbn = $_GET["isbn"];
$book = getBook($conn, $_GET["isbn"]);

$bookInventory = getInventory($conn, $isbn);
function echoIfPermission($permission, $echo) {
    if ($_SESSION["permission"]>=($permission)){
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

    <div class="management">
        <div class="header">
            <div class="logo">
                <a href="index.php"><img src="assets/logo.png"></a>
            </div>
            <div class="screen">
                <h1>Kirjan Tarkastus</h1>
            </div>
        </div>
        <div class="src">
            <div class="screen">
                <div class="alignment">
                    <div class="col-left"></div>
                    <div class="book-container">
                        <?php
                        echo "<h1>".$book["name"]. " (".$book["released"].")</h1>";
                        ?>

                        <div class="book-header">
                                <div class="info">
                                    <div style="width: 50%">
                                        <?php
                                        echo "<h3>ISBN</h3>";
                                        echo $book["isbn"];
                                        ?>
                                    </div>
                                    <div style="width: 50%">
                                        <?php
                                        echo "<h3>Kirjoittaja</h3>";
                                        echo $book["author"];
                                        ?>
                                    </div>
                                    <div>
                                        <?php
                                        echo "<h3>Julkaisija</h3>";
                                        echo $book["publisher"];
                                        ?>
                                    </div>
                                    <div>
                                        <?php
                                        echo "<h3>Kieli</h3>";
                                        echo $book["language"];
                                        ?>
                                    </div>
                                    <div class="">
                                        <?php
                                        echo "<h3>Kuvaus</h3>";
                                        echo $book["description"];
                                        ?>
                                    </div>
                                </div>
                                <div class="description">

                                </div>
                        </div>
                        <div class="book-footer">
                            <h1>Kopiot</h1>
                            <br>
                            <div class="">
                                <table class="content-table">
                                    <thead>
                                    <tr>
                                        <th>ISBN</th>
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
<button class='return' onclick='".js("bookReturn", $isbn, $item["id"], $book["name"], $item["borrower"], $item["borrow_end"]))."'>Palauta</button>
    </th>
</tr>";
                                                } else {
                                                    echo echoIfPermission(5,
                                                            "
<button class='return last-chance' onclick='".js("bookReturn", $isbn, $item["id"], $book["name"], $item["borrower"], $item["borrow_end"]))."'>Palauta</button>
    </th>
</tr>";

                                                }

                                            } else {
                                                echo echoIfPermission(5,
                                                        "
        <button type='submit' class='return' name='submit' onclick='".js("bookBorrow", $isbn, $item["id"], $book["name"])."'>Lainaa</button>
    ")
                                                    . "
    </th>
</tr>";
                                            }
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
            </div>
        </div>
    </div>


<?php
include_once "book.return.popup.php";
include_once "book.extend.popup.php";
include_once "book.add.popup.php";
include_once "book.borrow.popup.php";

include_once "footer.php";

