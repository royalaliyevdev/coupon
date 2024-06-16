<?php
require 'config.php';

if (isset($_GET['coupon_number'])) {
    $coupon_number = $_GET['coupon_number'];
    $file_path = "generated_coupons/coupon_$coupon_number.jpg";

    if (file_exists($file_path)) {
        header('Content-Type: image/jpeg');
        readfile($file_path);
    } else {
        echo "Coupon not found.";
    }
} else {
    echo "Invalid request.";
}
?>
