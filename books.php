<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
requireStyle("../css/bookstable.css");
requireScript("../javascript/popups/books.js");

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
                <button class='add' onclick='addBook()'>
                    Lisää Kirja
                </button>
");
                ?>

                <h1>Muokkaa Kirjoja</h1>
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
                            <th>Kirjoittaja</th>
                            <th>Nimi</th>
                            <th>Kuvaus</th>
                            <th>Kieli</th>
                            <th>Julkaisija</th>
                            <th>Julkaistu</th>
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
                <button class='borrow' type='submit' name='isbn' value='" . htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8') . "'>Muokkaa</button>
            </form>")
                                . echoIfPermission(10,
                                    "
        <button type='submit' class='delete' name='submit' onclick='".js("deleteBook", htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($book['name'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($book['description'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($book['language'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($book['publisher'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($book['released'], ENT_QUOTES, 'UTF-8'))."'
        >Poista Järjestelmästä</button>
"
                                    /*
    <form method='post' action='./build/delete_book.bld.php'>
        <input type='hidden' name='isbn' value='".htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8')."'>
        <button type='submit' class='delete' name='submit'>Poista</button>
    </form>
    ")
                                                                        */
                                    );
                                echo "
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
    include_once "books.add.popup.php";
    if (permission(10)){
        include_once "books.delete.popup.php";
    }
}