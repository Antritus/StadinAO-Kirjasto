<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
requireStyle("../css/bookstable.css");


if ($_SESSION["permission"] < 5){
    header("location: index.php?no_permissions=2");
    exit();
}

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";
global $conn;
$books = getBooks($conn, 0, 100);
if (!$books){
    header("location: index.php");
    exit();
}

include_once "header.php";

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
                <h1>Muokka Kirjoja</h1>
                <h3>Select Item: <span class="select-account">NONE</span></h3>
                <div style=""></div>
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
<tr>
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
                                . echoIfPermission(10, "<button class='delete'>Delete</button>")
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

