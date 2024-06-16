<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_ids'])) {
    $coupon_ids = $_POST['coupon_ids'];
    foreach ($coupon_ids as $coupon_id) {
        $sql = "DELETE FROM coupons WHERE coupon_number = '$coupon_id'";
        $conn->query($sql);

        // Delete the related files
        unlink("../qrcodes/$coupon_id.png");
        unlink("../generated_coupons/coupon_$coupon_id.jpg");
        unlink("../generated_coupons/rotated_coupon_$coupon_id.jpg");
        unlink("../generated_coupons/coupon_$coupon_id.pdf");
    }
}

$conn->close();
header("Location: list.php");
exit;
?>
