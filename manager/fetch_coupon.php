<?php
require '../config.php';

if (isset($_GET['token'])) {
    $encrypted_number = $_GET['token'];
    $prefix = "lumusoft";

    $sql = "SELECT coupon_number FROM coupons WHERE encrypted_number = '$encrypted_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $coupon_number = $row['coupon_number'];

        // Fetch coupon details using the coupon number
        $coupon_sql = "SELECT * FROM coupons WHERE coupon_number = '$coupon_number'";
        $coupon_result = $conn->query($coupon_sql);
        if ($coupon_result->num_rows > 0) {
            $coupon = $coupon_result->fetch_assoc();
            echo json_encode(['success' => true, 'coupon' => $coupon]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Coupon not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid token']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No token provided']);
}
?>
