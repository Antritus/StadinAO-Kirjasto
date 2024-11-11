<?php
include_once "init.php";
requireStyle("../css/manage_users.css");
requireStyle("../css/userstable.css");


if ($_SESSION["permission"] < 5){
    header("location: index.php?no_permissions=2");
    exit();
}

include_once "./build/dbh.inc.php";
include_once "./build/functions.bld.php";
global $conn;
$accounts = getAccounts($conn, 0, 100);
if (!$accounts){
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
                <h1>Account Manager</h1>
                <h3>Select Account: <span class="select-account">NONE</span></h3>
            </div>
        </div>
        <div class="src">
            <div class="screen">
                <div class="alignment">
                    <div class="col-left"></div>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>Account Id</th>
                                <th>E-Mail</th>
                                <th>@Account</th>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < 100; $i++){
                            if (empty($accounts[$i])){
                                break;
                            }
                            $account = $accounts[$i];
                                echo "   
                                                        <tr>
                            <th>{$account['id']}</th>
                            <th>{$account['email']}</th>
                            <th>{$account['accountName']}</th>
                            <th>{$account['name']}</th>
                            <th>{$account['surname']}</th>
                            <th>{$account['birthday']}</th>
                            <th>{$account['address']}, {$account['postcode']}, {$account['postArea']}</th>
                            <th class='edit-buttons'>".
                                    echoIfPermission(10, "<button class='edit'>Edit</button>").
                                    echoIfPermission(10, "<button class='delete'>Delete</button>").
  //                          <button class='edit'>EDIT</button>
//                            ".
//                                    echoIfPermission(5, "<button class='edit-details'>Edit Details</button>") .
  //                                  echoIfPermission(5, "<button class='borrow'>Borrow</button>") .
    //                                echoIfPermission(8, "<button class='history'>History</button>") .
      //                              echoIfPermission(10, "<button class='edit-details'>Delete</button>")."
                            "
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

