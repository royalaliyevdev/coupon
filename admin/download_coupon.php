<?php
require '../config.php';

if (isset($_GET['coupon_number'])) {
    $coupon_number = intval($_GET['coupon_number']);
    $file_path = "../generated_coupons/coupon_$coupon_number.pdf";

    if (file_exists($file_path)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="coupon_' . $coupon_number . '.pdf"');
        readfile($file_path);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
