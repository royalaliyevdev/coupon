<?php
session_start();
if ($_SESSION['role'] != 'store') {
    header("Location: login.php");
    exit();
}
// Store panel içeriği
echo "Mağaza Paneli";
?>
