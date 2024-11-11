<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
requireStyle("../css/bookstable.css");

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
                <h1>Borrowable Manager</h1>
                <h3>Select Item: <span class="select-account">NONE</span></h3>
            </div>
        </div>
        <div class="src">
            <div class="screen">
                <div class="alignment">
                    <div class="col-left"></div>
                    <div>
                        <h1>
                            <?php echo $_GET["isbn"] ?>
                        </h1>
                    </div>
                    <div class="col-right"></div>
                </div>
            </div>
        </div>
    </div>


<?php
include_once "footer.php";

