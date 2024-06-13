<?php
include('database/db.php'); // Veritabanı bağlantısı

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Şifreyi hashleme
$role = $_POST['role'];

$query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
mysqli_query($conn, $query);

echo "Kayıt başarılı!";
