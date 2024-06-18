<?php include '../resources/views/admin/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $store_id = $_POST['store_id'];

    // Check if there are any coupons associated with this store
    $check_sql = "SELECT COUNT(*) AS count FROM coupons WHERE store_id = '$store_id'";
    $check_result = $conn->query($check_sql);
    $check_row = $check_result->fetch_assoc();

    if ($check_row['count'] > 0) {
        echo "Cannot delete store with active coupons.";
    } else {
        // Delete the store
        $sql = "DELETE FROM stores WHERE id = '$store_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Store deleted successfully";
        } else {
            echo "Error deleting store: " . $conn->error;
        }
    }

    $conn->close();
    header("Location: list_stores.php");
    exit;
}
?>
