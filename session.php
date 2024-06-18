<?php
require 'session_manager.php';

// Eğer oturum açılmamışsa login sayfasına yönlendir
if (!isset($_SESSION['user_type'])) {
    header("Location: ../login.php");
    exit();
}

// Eğer mağaza yetkilisi değilse mağaza paneline erişemez
function checkStoreAccess() {
    if ($_SESSION['user_type'] !== 'store') {
        header("Location: ../login.php");
        exit();
    }
}

// Eğer yönetici değilse yönetici paneline erişemez
function checkAdminAccess() {
    if ($_SESSION['user_type'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }
}

// Eğer yönetici veya mağaza yetkilisi değilse logout sayfasına yönlendir
function checkManagerAccess() {
    if ($_SESSION['user_type'] !== 'manager') {
        header("Location: ../login.php");
        exit();
    }
}
?>
