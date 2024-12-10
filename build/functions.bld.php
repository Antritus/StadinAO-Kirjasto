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
            "name"=>$row["name"],
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
function getAccount($conn, $id) {
    $query = "SELECT * FROM users WHERE userid = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)) {
        return array(
            "id"=>$row["userid"],
            "email"=>$row["email"],
            "accountName" => (empty($row["accountName"]) ? NULL : $row["accountName"]),
            "name"=>$row["name"],
            "surname"=>$row["sName"],
            "address"=>$row["address"],
            "postcode"=>$row["postcode"],
            "postArea"=>$row["postArea"],
            "birthday"=>$row["birthday"],
        );
    }

    return false;
}

function getBooks($conn, $start, $end) {
    $query = "SELECT * FROM books WHERE category = ? LIMIT ? OFFSET ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }
    $category = "Book";

    mysqli_stmt_bind_param($stmt, "sii", $category, $end, $start);
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
function getItems($conn, $start, $end) {
    $query = "SELECT * FROM books WHERE category != ? LIMIT ? OFFSET ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    $category = "Book";

    mysqli_stmt_bind_param($stmt, "sii", $category, $end, $start);
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
            "publisher" => $row["publisher"] ?? null,
            "category" => $row["category"] ?? null
        );
        $i++;
    }

    return !empty($books) ? $books : false;
}
function getItemsByCategory($conn, $start, $end, $category) {
    $query = "SELECT * FROM books WHERE category = ? LIMIT ? OFFSET ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sii", $category, $end, $start);
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
            "publisher" => $row["publisher"] ?? null,
            "category" => $row["category"] ?? null
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
            "publisher" => $row["publisher"] ?? null,
            "category" => $row["category"] ?? null
        );
    }
    return false;
}

function createBook($conn, mixed $name, mixed $author, mixed $publisher, mixed $published, mixed $language, mixed $isbn, mixed $description)
{
    $query = "INSERT INTO books (isbn, name, description, language, released, author, publisher) VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../books.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $isbn, $name, $description, $language, $published, $author, $publisher);
    mysqli_stmt_execute($stmt);
}
function createWish($conn, mixed $name, mixed $author, mixed $publisher, mixed $published, mixed $language, mixed $isbn, mixed $description)
{
    $query = "INSERT INTO wishes (isbn, name, description, language, released, author, publisher) VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../books.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $isbn, $name, $description, $language, $published, $author, $publisher);
    mysqli_stmt_execute($stmt);
}
function createItem($conn, mixed $isbn, mixed $name, mixed $description, $released, mixed $brand, $category, $language)
{
    $query = "INSERT INTO books (isbn, name, description, released, publisher, category, language) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../books.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $isbn, $name, $description, $released, $brand, $category, $language);
    mysqli_stmt_execute($stmt);
}

function deleteBook($conn, $isbn)
{
    $query = "DELETE FROM books WHERE isbn = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../books.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $isbn);
    mysqli_stmt_execute($stmt);
}
function deleteWish($conn, $isbn)
{
    $query = "DELETE FROM wishes WHERE isbn = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../wishes.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $isbn);
    mysqli_stmt_execute($stmt);
}
function getInventory($conn, $isbn)
{
    $query = "SELECT * FROM item_isbn WHERE isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $isbn);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    $i = 0;
    $items = [];
    while ($row = mysqli_fetch_assoc($resultSet)) {
        $items[$i] = array(
            "isbn"=> $row["isbn"] ?? null,
            "id"=>$row["id"] ?? null,
            "description"=>$row["description"] ?? null,
            "borrower" => $row["borrowed"] ?? null,
            "borrow_start"=>$row["dateBorrowed"] ?? null,
            "borrow_end" => $row["licenseEnds"] ?? null
        );
        $i++;
    }
    return $items;
}
function deleteAccount(bool|the|mysqli $conn, mixed $id)
{
    $query = "DELETE FROM users WHERE userid =?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location:../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $books = getBorrowedAccount($conn, $id);
    foreach ($books as $book) {
        cancelBorrow($conn, $book['isbn'], $book["id"]);
    }
}

function getBorrowedAccount(bool|the|mysqli $conn, mixed $id)
{
    $query = "SELECT * FROM item_isbn WHERE borrowed = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    $i = 0;
    $items = [];
    while ($row = mysqli_fetch_assoc($resultSet)) {
        $items[$i] = array(
            "isbn"=> $row["isbn"] ?? null,
            "id"=>$row["id"] ?? null,
            "description"=>$row["description"] ?? null,
            "borrower" => $row["borrowed"] ?? null,
            "borrow_start"=>$row["dateBorrowed"] ?? null,
            "borrow_end" => $row["licenseEnds"] ?? null
        );
        $i++;
    }
    return $items;
}
function getItem($conn, $isbn, $isbnItem)
{
    $query = "SELECT * FROM item_isbn WHERE isbn = ? AND id = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $isbn, $isbnItem);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)) {
        return array(
            "isbn"=> $row["isbn"] ?? null,
            "id"=>$row["id"] ?? null,
            "description"=>$row["description"] ?? null,
            "borrower" => $row["borrowed"] ?? null,
            "borrow_start"=>$row["dateBorrowed"] ?? null,
            "borrow_end" => $row["licenseEnds"] ?? null
        );
    }
    return null;
}

function deleteItems($conn, $isbn)
{
    $query = "DELETE FROM item_isbn WHERE isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../books.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $isbn);
    mysqli_stmt_execute($stmt);
}
function getPermission($conn, $id)
{
    $query = "SELECT * FROM users WHERE userid = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index.php?error=stmt_failure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)) {
        return $row["permission"] ?? null;
    }
    return 0;
}

function addBookCopy($conn, $isbn, $isbnBook, $description): void
{
    $query = "INSERT INTO item_isbn (id, isbn, description) VALUES (?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../book.php?error=stmt_failure&isbn=$isbn");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $isbnBook, $isbn, $description);
    mysqli_stmt_execute($stmt);
}
function deleteBookCopy($conn, $isbn, $isbnBook): void
{
    $query = "DELETE FROM item_isbn WHERE id = ? AND isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../book.php?error=stmt_failure&isbn=$isbn");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $isbnBook, $isbn);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function isBorrowed($conn, $isbn, $isbnBook) : bool{
    $query = "SELECT * FROM item_isbn WHERE id = ? AND isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../book.php?error=stmt_failure&isbn=$isbn");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $isbnBook, $isbn);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)) {
        if (isset($row["borrowed"])){
            return true;
        }
        return false;
    }
    return false;
}
function extendBorrow($conn, $isbn, $isbnBook, $newDate): void
{
    $query = "UPDATE item_isbn SET licenseEnds = ? WHERE id = ? AND isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../book.php?error=stmt_failure&isbn=$isbn");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $newDate, $isbnBook, $isbn);
    mysqli_stmt_execute($stmt);
}
function borrow($conn, $account, $isbn, $isbnBook, $returnDate): void
{
    $query = "UPDATE item_isbn SET borrowed = ?, dateBorrowed = ?, licenseEnds = ? WHERE id = ? AND isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../book.php?error=stmt_failure&isbn=$isbn");
        exit();
    }

    $dateToday = date("Y-m-d");

    mysqli_stmt_bind_param($stmt, "issss", $account, $dateToday, $returnDate, $isbnBook, $isbn);
    mysqli_stmt_execute($stmt);
}
function itemIsbnExists($conn, $isbn, $isbnBook){
    $query = "SELECT * FROM item_isbn WHERE id = ? AND isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../book.php?error=stmt_failure&isbn=$isbn");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $isbnBook, $isbn);
    mysqli_stmt_execute($stmt);

    $resultSet = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultSet)) {
        return true;
    }
    return false;
}
function cancelBorrow(bool|the|mysqli $conn, mixed $isbn, mixed $isbnBook): void
{
    $query = "UPDATE item_isbn SET borrowed = NULL, dateBorrowed = NULL, licenseEnds = NULL WHERE id = ? AND isbn = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../book.php?error=stmt_failure&isbn=$isbn");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $isbnBook, $isbn);
    mysqli_stmt_execute($stmt);
}