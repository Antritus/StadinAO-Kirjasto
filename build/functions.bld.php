<?php

function siteURL($direction)
{
    return $direction;
}


function anyFieldsEmpty(...$fields): bool
{
    for ($i = 0; $i < sizeof($fields); $i++){
        if (!isset($i)){
            return true;
        }
    }
    return false;
}

function invalidEmail($email): bool
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function passwordDontMatch($pswd, $pswdR): bool
{
    return $pswd !== $pswdR;
}

function emailAlreadyExists($conn, $email)
{
    $query = "SELECT * FROM users WHERE email = ? OR accountName = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)){
        header("location: ../index.php?signup=stmt_failure");
        exit();
    }

    $strtolower = strtolower($email);
    mysqli_stmt_bind_param($stmt, "ss", $strtolower, $strtolower);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)){
        return $row;
    } else {
        return false;
    }
}

function login($conn, $email, $pswd) {
    // Check if the email exists in the database
    $row = emailAlreadyExists($conn, $email);

    if ($row === false) {
        return false;
    }

    $hashed_password = $row["pswd"];

    if (!password_verify($pswd, $hashed_password)) {
        return false; // Password verification failed
    }

    logInIncl($row);

    header("Location: ../index.php");
    exit();
}


function createUser($conn, $name, $surname, $birthday, $email, $pswd, $address, $postcode, $postarea)
{
    $query = "INSERT INTO users (name, sName, address, postcode, postArea, birthday, email, pswd) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?signup=stmt_failure");
        exit();
    }

    $hashPswd = password_hash($pswd, PASSWORD_DEFAULT);
    $strtolower = strtolower($email);
    mysqli_stmt_bind_param($stmt, "sssissss", $name, $surname, $address, $postcode, $postarea, $birthday, $strtolower, $hashPswd);//$hashPswd);
    mysqli_stmt_execute($stmt);

    createPermissions($conn, emailAlreadyExists($conn, $email));
}
function createPermissions($conn, $row){
    $query = "INSERT INTO permissions (id, account) VALUES (?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?signup=stmt_failure");
        exit();
    }

    $id = $row["userid"];
    $accountLevel = 0;
    mysqli_stmt_bind_param($stmt, "ii", $id, $accountLevel);
    mysqli_stmt_execute($stmt);

    header("location: ../index.php?signup=none");
}

function logInIncl($row) {
    session_start();
    $_SESSION["name"] = $row["name"];
    $_SESSION["sName"] = $row["sName"];
    $_SESSION["email"] = $row["email"];
    $_SESSION["logged"] = true;
    $_SESSION["id"] = $row["userid"];
    $_SESSION["permission"] = $row["permission"];
}
function getAccounts($conn, $start, $end) {
    $query = "SELECT * FROM users LIMIT ? OFFSET ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $end, $start);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    $i = 0;
    $accounts = [];
    while ($row = mysqli_fetch_assoc($resultSet)) {
        $accounts[$i] = array(
            "id"=>$row["userid"],
            "email"=>$row["email"],
            "accountName" => (empty($row["accountName"]) ? NULL : $row["accountName"]),
            "name"=>$row["email"],
            "surname"=>$row["sName"],
            "address"=>$row["address"],
            "postcode"=>$row["postcode"],
            "postArea"=>$row["postArea"],
            "birthday"=>$row["birthday"],
        );
        $i++;
    }

    return !empty($accounts) ? $accounts : false;
}

function getBooks($conn, $start, $end) {
    $query = "SELECT * FROM books LIMIT ? OFFSET ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $end, $start);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    $i = 0;
    $books = [];
    while ($row = mysqli_fetch_assoc($resultSet)) {
        $books[$i] = array(
            "isbn" => $row["isbn"] ?? null,
            "name" => $row["name"] ?? null,
            "description" => $row["description"] ?? null,
            "language" => $row["language"] ?? null,
            "released" => $row["released"] ?? null,
            "author" => $row["author"] ?? null,
            "publisher" => $row["publisher"] ?? null
        );
        $i++;
    }

    return !empty($books) ? $books : false;
}

function getBook($conn, $isbn){
    $query = "SELECT * FROM books WHERE isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $isbn);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)) {
        return array(
            "isbn" => $row["isbn"] ?? null,
            "name" => $row["name"] ?? null,
            "description" => $row["description"] ?? null,
            "language" => $row["language"] ?? null,
            "released" => $row["released"] ?? null,
            "author" => $row["author"] ?? null,
            "publisher" => $row["publisher"] ?? null
        );
    }
    return false;
}