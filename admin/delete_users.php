<?php
session_start();
require '../config.php';

// Admin girişi kontrolü
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Kullanıcıyı silme
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    if ($stmt->execute()) {
        header("Location: list_users.php");
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
} else {
    header("Location: list_users.php");
    exit();
}

$stmt->close();
$conn->close();
?>
