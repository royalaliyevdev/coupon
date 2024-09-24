<?php
include '../resources/views/admin/header.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Kullanıcı bilgilerini çekme
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    header("Location: list_users.php");
    exit();
}

// Kullanıcı güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $user_type = $_POST['user_type'];
    $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : NULL;

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username = ?, password = ?, user_type = ?, store_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssii', $username, $password, $user_type, $store_id, $user_id);
    } else {
        $sql = "UPDATE users SET username = ?, user_type = ?, store_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $username, $user_type, $store_id, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: list_users.php");
        exit();
    } else {
        $error = "Error updating user: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit User</h2>
    <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="post" action="">
        <div class="form-group">
            <input type="text" class="form-control uponInput" name="username" placeholder="Username" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control uponInput" name="password" placeholder="Password (leave blank to keep current password)">
        </div>
        <div class="form-group">
            <select class="form-control uponInput" name="user_type" required>
                <option value="admin" <?php if ($user['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="manager" <?php if ($user['user_type'] == 'manager') echo 'selected'; ?>>Manager</option>
                <option value="store" <?php if ($user['user_type'] == 'store') echo 'selected'; ?>>Store</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control uponInput" name="store_id">
                <option value="">No Store (for Admin or Manager)</option>
                <?php
                $sql = "SELECT id, name FROM stores";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $selected = ($user['store_id'] == $row['id']) ? 'selected' : '';
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn uponButton">Update User</button>
    </form>
</div>
</body>
</html>

<?php
include '../resources/views/admin/footer.php';
$conn->close();
?>
