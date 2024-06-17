<?php
session_start();
require '../config.php';

// Mağaza ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $store_name = $_POST['store_name'];
    $sql = "INSERT INTO stores (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $store_name);
    $stmt->execute();
    $stmt->close();
    header("Location: list_stores.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add Store</h2>
    <form method="post" action="">
        <div class="form-group">
            <input type="text" class="form-control" name="store_name" placeholder="Store Name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Store</button>
    </form>
</div>
</body>
</html>
