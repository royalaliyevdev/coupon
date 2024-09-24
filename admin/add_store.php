<?php
include '../resources/views/admin/header.php';

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


    <h2>Add Store</h2>
    <form method="post" action="">
        <div class="form-group">
            <input type="text" class="form-control uponInput" name="store_name" placeholder="Store Name" required>
        </div>
        <button type="submit" class="btn btn-primary uponButton">Add Store</button>
    </form>
<?php include '../resources/views/admin/footer.php'; ?>
