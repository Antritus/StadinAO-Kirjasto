<?php

$WEB_URL = "http://localhost/kirjasto/";
function siteURL($direction)
{
    global $WEB_URL;
    return $WEB_URL . $direction . ".php";
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
    $query = "SELECT * FROM users WHERE email = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)){
        header("location: ../index.php?signup=true&error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)){
        return $row;
    } else {
        return false;
    }
}

function createUser($conn, $name, $surname, $birthday, $email, $pswd, $address, $postcode, $postarea)
{
    $query = "INSERT INTO users (name, sName, address, postcode, postArea, birthday, email, pswd) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?signup=true&error=stmt_failure");
        exit();
    }

    $hashPswd = password_hash($pswd, PASSWORD_DEFAULT);


    mysqli_stmt_bind_param($stmt, "sssissss", $name, $surname, $address, $postcode, $postarea, $birthday, $email, $hashPswd);
    mysqli_stmt_execute($stmt);
    header("location: ../index.php?signup=true&error=none");
}