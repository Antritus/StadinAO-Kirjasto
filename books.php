<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
requireStyle("../css/bookstable.css");
requireScript("../javascript/book.fc.js");

if ($_SESSION["permission"] < 5){
    header("location: index.php?no_permissions=2");
    exit();
}

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";
global $conn;
$books = getBooks($conn, 0, 100);

include_once "header.php";
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
?>

    <div class="management">
        <div class="header">
            <div class="logo">
                <a href="index.php"><img src="assets/logo.png"></a>
            </div>
            <div class="screen">
                <?php
                echo echoIfPermission(5, "
                <div class='add' onclick='addBook()'>
                    Lisää Kirja
                </div>
");
                ?>

                <h1>Muokka Kirjoja</h1>
                <h3>Select Item: <span class="select-account">NONE</span></h3>
            </div>
        </div>
        <div class="src">
            <div class="screen">
                <div class="alignment">
                    <div class="col-left"></div>
                    <table class="content-table">
                        <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Author</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Language</th>
                            <th>Publisher</th>
                            <th>Released</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < 100; $i++){
                            if (empty($books[$i])){
                                break;
                            }
                            $book = $books[$i];
                            echo "
<tr id='{$book["name"]}'>
    <th>" . htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8') . "</th>
    <th>" . htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') . "</th>
    <th>" . htmlspecialchars($book['name'], ENT_QUOTES, 'UTF-8') . "</th>
    <th>" . htmlspecialchars($book['description'], ENT_QUOTES, 'UTF-8') . "</th>
    <th>" . htmlspecialchars($book['language'], ENT_QUOTES, 'UTF-8') . "</th>
    <th>" . htmlspecialchars($book['publisher'], ENT_QUOTES, 'UTF-8') . "</th>
    <th>" . htmlspecialchars($book['released'], ENT_QUOTES, 'UTF-8') . "</th>
    <th class='edit-buttons'>"
                                . echoIfPermission(5, "
            <form action='book.php' method='get'>
                <button class='borrow' type='submit' name='isbn' value='" . htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8') . "'>Manage</button>
            </form>")
                                . echoIfPermission(10,
                                    "
    <form method='post' action='./build/delete_book.bld.php'>
        <input type='hidden' name='isbn' value='".htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8')."'>
        <button type='submit' class='delete' name='submit'>Delete</button>
    </form>
    ")
                                . "
    </th>
</tr>";

                        }
                        ?>
                        </tbody>
                    </table>

                    <div class="col-right"></div>
                </div>
            </div>
        </div>
    </div>
<?php
include_once "footer.php";

if (permission(5)){
    include_once "book.fc.php";
}
