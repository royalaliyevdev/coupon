<?php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_number = $_POST['coupon_number'];
    $store_id = $_SESSION['store_id'];

    // Check if coupon belongs to the store and is not used
    $sql = "SELECT * FROM coupons WHERE coupon_number = ? AND store_id = ? AND status = 'active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $coupon_number, $store_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);

        // Update coupon status and add product image
        $sql = "UPDATE coupons SET product_image = ?, status = 'active', used = 'yes' WHERE coupon_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $target_file, $coupon_number);
        if ($stmt->execute()) {
            echo "Coupon used successfully";
        } else {
            echo "Error updating coupon: " . $stmt->error;
        }
    } else {
        echo "Coupon not found or already used.";
    }
    $stmt->close();
}
$conn->close();
//header("Location: index.php");
exit();
?>
