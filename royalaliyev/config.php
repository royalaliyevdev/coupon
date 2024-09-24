<?php
$mysqli = new mysqli("localhost", "root", "", "royalaliyev");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
