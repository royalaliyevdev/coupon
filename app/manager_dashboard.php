<?php
session_start();
if ($_SESSION['role'] != 'manager') {
    header("Location: login.php");
    exit();
}
$title = "Ana Sayfa";
$content = "../layout/index_content.php";
include('../layout/layout.php');
?>
