<?php
session_start();
require '../config.php';

// Kullanıcı ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $_POST['user_type'];
    $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : NULL;

    $sql = "INSERT INTO users (username, password, user_type, store_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $username, $password, $user_type, $store_id);
    $stmt->execute();
    $stmt->close();
    header("Location: list_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add User</h2>
    <form method="post" action="">
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <select class="form-control" name="user_type" required>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="store">Store</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="store_id">
                <option value="">No Store (for Admin or Manager)</option>
                <?php
                $sql = "SELECT id, name FROM stores";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>
</body>
</html>
