<?php
include('database/db.php'); // Veritabanı bağlantısı

$username = $_POST['username'];
$password = md5($_POST['password']); // Şifreyi MD5 ile şifrele
$role = $_POST['role'];

$query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
mysqli_query($conn, $query);

echo "Kayıt başarılı!";
?>
