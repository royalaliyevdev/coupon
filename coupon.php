<?php
require '../config.php';

    if ($coupon_number !== false) {
        $sql = "SELECT * FROM coupons WHERE coupon_number = $coupon_number";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $coupon = $result->fetch_assoc();
            echo json_encode(['success' => true, 'coupon' => $coupon]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Coupon not found in database']);
        }
    }
 else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
?>
