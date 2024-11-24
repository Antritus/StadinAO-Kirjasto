<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
//requireStyle("../css/userstable.css");
requireStyle("../css/bookinfo.css");
requireStyle("../css/bookstable.css");
//requireScript("../javascript/popups/account.js");
requireScript("../javascript/popups/book.js");


if (!isset($_GET["id"])){
    header("location: accounts.php");
}

if ($_SESSION["permission"] < 5){
    header("location: index.php?no_permissions=2");
    exit();
}

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";
include_once "init.php";

global $conn;

$id = $_GET["id"];
$account = getAccount($conn, $id);
$accountInventory = getBorrowedAccount($conn, $id);

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
                        <span class="item-path"><a href="accounts.php">Käyttäjät</a> > <a href="account.php?isbn=<?php echo $id; ?>"><?php echo $account["name"] . " " . $account["surname"]; ?></a></span>
                        <div class="book-header">
                                <form class="modal-content animate" method="post" action="build/book.borrow.bld.php">
                                    <div class="imgcontainer">
                                        <h1><?php echo $account["name"];?></h1>
                                    </div>

                                    <div class="container">
                                        <div style="display: inline">
                                            <div style="width: 49.5%; float: left; margin-right: 1%">
                                                <label for="book-name"><b>Etunimi</b></label>
                                                <input type="text" placeholder="Etunimi..." name="acc-name" id="acc-name" value="<?php echo $account["name"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                            <div style="width: 49.5%; float: right">
                                                <label for="book-author"><b>Sukunimi</b></label>
                                                <input type="text" placeholder="Sukunimi..." name="acc-surname" id="acc-surname" value="<?php echo $account["surname"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                        </div>
                                        <div style="display: inline">
                                            <div style="width: 18.5%; float: left; margin-right: 1%">
                                                <label for="book-publisher"><b>Käyttäjä Id</b></label>
                                                <input type="text" placeholder="Käyttäjä Id..." name="acc-id" id="acc-id" value="<?php echo $account["id"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                            <div style="float: left; width: 29.5%; margin-right: 1%">
                                                <label for="acc-acc-name"><b>Käyttäjä nimi</b></label>
                                                <input type="text" name="acc-acc-name" id="acc-acc-name" value="<?php echo $account["accountName"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                            <div style="float: right; width: 49.5%;">
                                                <label for="acc-email"><b>Email</b></label>
                                                <input type="email" name="acc-email" id="acc-email" value="<?php echo $account["email"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                        </div>
                                        <div style="display: inline" class="address-container">
                                            <div style="float: left; width: 39%; margin-right: 1%">
                                                <label for="address"><b>Osoite</b></label>
                                                <input type="text" placeholder="Osoite..." name="add-address" value="<?php echo $account["address"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                            <div style="float: left; width: 29.5%; margin-right: 1%">
                                                <label for="postcode"><b>Postinumero</b></label>
                                                <input type="text" placeholder="Postinumero..." name="add-postcode" value="<?php echo $account["postcode"]; ?>" required <?php echo echoIfNoPermission(5, "readonly"); ?>>
                                            </div>
                                            <div style="float: left; width: 29.5%;">
                                                <label for="postarea"><b>Postitoimialue</b></label>
                                                <select id="country" name="add-postarea">
                                                    <option value="Espoo" <?php echo ($account["postArea"]=="Espoo") ? "selected" : "";?>>Espoo</option>
                                                    <option value="Helsinki" <?php echo ($account["postArea"]=="Helsink") ? "selected" : "";?>>Helsinki</option>
                                                    <option value="Vantaa" <?php echo ($account["postArea"]=="Vantaa") ? "selected" : "";?>>Vantaa</option>
                                                </select>
                                            </div>
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
                                <h1>Lainatut Kirjat/Tavarat</h1>
                            </div>
                            <div class="container">
                            <table class="content-table">
                                <thead>
                                <tr>
                                    <th>ISBN</th>
                                    <th>ISBN (Kopio)</th>
                                    <th>Nimi</th>
                                    <th>Tietoa</th>
                                    <th>Lainaus Alkanut</th>
                                    <th>Lainaus Päättyy</th>
                                    <th>Lainaus Ajan Yli</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($accountInventory)) {
                                    for ($i = 0; $i < 100; $i++) {
                                        if (empty($accountInventory[$i])) {
                                            break;
                                        }
                                        $item = $accountInventory[$i];
                                        $extraInfo = getBook($conn, $item["isbn"]);

                                        $id = $item['id'];
                                        echo "
<tr ".(isPastLicense($item["borrow_end"]) ? "class='last-chance'" : "") .">
    <th>" . valueOrDash($item["id"]) . "</th>
    <th>" . valueOrDash($item["isbn"]) . "</th>
    <th>" . valueOrDash($extraInfo['name']) . "</th>
    <th>" . valueOrDash($item['description']) . "</th>
    <th>" . valueOrDash($item['borrow_start']) . "</th>
    <th>" . valueOrDash($item['borrow_end']) . "</th>
    <th>" . pastLicense($item['borrow_end']) . "</th>
    <th class='edit-buttons'>";
                                        if (valueOrDash($item["borrower"]) !== "-") {
                                            if (!isPastLicense($item["borrow_end"])) {
                                                echo echoIfPermission(5, "
                <button class='borrow' type='submit' name='isbn' onclick='".js("extend", $item["isbn"], $item["id"], $extraInfo["name"], $item['borrower'])."'>Pidennä Lainausta</button>");
                                                echo echoIfPermission(5,
                                                        "
<button class='return' onclick='".js("bookReturn", $item["isbn"], $item["id"], $extraInfo["name"], $item["borrower"], $item["borrow_end"]))."'>Palauta</button>
    </th>
</tr>";
                                            } else {
                                                echo echoIfPermission(5,
                                                        "
<button class='return last-chance' onclick='".js("bookReturn", $item["isbn"], $item["id"], $extraInfo["name"], $item["borrower"], $item["borrow_end"]))."'>Palauta</button>
    </th>
</tr>";

                                            }

                                        } else {
                                            echo echoIfPermission(5,
                                                    "
        <button type='submit' class='return' name='submit' onclick='".js("bookBorrow", $item["isbn"], $item["id"], $extraInfo["name"])."'>Lainaa</button>
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


<?php
include_once "book.return.popup.php";
include_once "book.extend.popup.php";
include_once "book.add.popup.php";
include_once "book.borrow.popup.php";

include_once "footer.php";

