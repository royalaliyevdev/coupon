<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coupon";

// Veritabanına bağlantı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

