<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "auth";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbpassword);
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM accounts WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);
    if ($result->num_rows == 1){
        exit();
    } else {
        exit();
    }

    $conn->close();
}

?>