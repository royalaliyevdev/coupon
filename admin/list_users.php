<?php
include '../resources/views/admin/header.php';

// Kullanıcıları listeleme
$sql = "SELECT u.id, u.username, u.user_type, s.name as store_name FROM users u LEFT JOIN stores s ON u.store_id = s.id";
$result = $conn->query($sql);
?>
<body>
<div class="container mt-5">
    <h2>List of Users</h2>
    <a href="add_user.php" class="btn btn-primary mb-3">Add New User</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>User Type</th>
            <th>Store</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['user_type']; ?></td>
                <td><?php echo $row['store_name'] ? $row['store_name'] : 'N/A'; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php include '../resources/views/admin/footer.php'; ?>
