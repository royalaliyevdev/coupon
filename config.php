<?php
$servername = "95.217.229.90";
$username = "upon_general_us";
$password = "fN7bZ4oK4i";
$dbname = "upon_general";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
