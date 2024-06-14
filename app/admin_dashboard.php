<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$title = "Admin Paneli";
$content = "../../layout/index_content.php";
include('../../layout/layout.php');
?>
