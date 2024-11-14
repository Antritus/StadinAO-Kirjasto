<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
requireStyle("../css/bookstable.css");
requireStyle("../css/bookinfo.css");


if (!isset($_GET["isbn"])){
    header("location: index.php");
}

if ($_SESSION["permission"] < 5){
    header("location: index.php?no_permissions=2");
    exit();
}

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";
global $conn;

if (!isset($_GET["isbn"])){
    header("location: books.php");
}

$book = getBook($conn, $_GET["isbn"]);

$bookInventory = getInventory($conn, $_GET["isbn"]);
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
        return "<span style='borrowed-true'>Kyllä</span>";
    } else {
        return "<span style='borrowed-false'>Ei</span>";
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

include_once "header.php";
?>

    <div class="management">
        <div class="header">
            <div class="logo">
                <a href="index.php"><img src="assets/logo.png"></a>
            </div>
            <div class="screen">
                <h1>Borrowable Manager</h1>
                <h3>Select Item: <span class="select-account">NONE</span></h3>
            </div>
        </div>
        <div class="src">
            <div class="screen">
                <div class="alignment">
                    <div class="col-left"></div>
                    <div class="book-container">
                        <div class="book-header">
                                <div></div>
                                <h1>
                                    <?php
                                    echo $book["name"];
                                    echo $book["isbn"];
                                    echo $book["description"];
                                    echo $book["language"];
                                    echo $book["released"];
                                    echo $book["author"];
                                    echo $book["publisher"];
                                    ?>
                                </h1>
                                <?php
                                echo $book["isbn"];
                                ?>
                        </div>
                        <div class="book-footer">
                            <h1>Fysikaaliset Kirjat</h1>
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
                                        <th></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $isbn = $book["isbn"];
                                    $isbnPaste = htmlspecialchars($isbn, ENT_QUOTES, 'UTF-8');
                                    if (isset($bookInventory)) {
                                        for ($i = 0; $i < 100; $i++) {
                                            if (empty($bookInventory[$i])) {
                                                break;
                                            }
                                            $item = $bookInventory[$i];
                                            $id = $item['id'];
                                            echo "
<tr>
    <th>" . valueOrDash($id) . "</th>
    <th>" . borrowed($item['borrower']) . "</th>
    <th>" . valueOrDash($item['borrower']) . "</th>
    <th>" . valueOrDash($item['borrow_start']) . "</th>
    <th>" . valueOrDash($item['borrow_end']) . "</th>
    <th>" . pastLicense($item['borrow_end']) . "</th>
    <th class='edit-buttons'>"
                                                . echoIfPermission(5, "
            <form action='./build/extend_book_return.bld.php' method='post'>
                <button class='borrow' type='submit' name='isbn' value='" . $isbnPaste . "'>Manage</button>
            </form>")
                                                . echoIfPermission(10,
                                                    "
    <form method='post' action='./build/return_book.bld.php'>
        <input type='hidden' name='isbn' value='" . htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') . "'>
        <button type='submit' class='return' name='submit'>Palauta</button>
    </form>
    ")
                                                . "
    </th>
</tr>";

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
include_once "footer.php";

