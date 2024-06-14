<?php
session_start(); // Oturumu başlat

// Kullanıcının giriş yapıp yapmadığını kontrol et
if(!isset($_SESSION['username'])) {
    // Giriş yapmamışsa login sayfasına yönlendir
    header("Location: login.html");
    exit();
}

$title = "Ana Sayfa";
$content = "layout/home.php";
include('layout/layout.php');
?>
