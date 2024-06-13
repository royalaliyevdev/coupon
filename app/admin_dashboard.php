<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
$title = "Admin";
include('../layout/admin.php');
?>
