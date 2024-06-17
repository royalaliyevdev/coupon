<?php
require 'config.php';

if (isset($_GET['token'])) {
    $encrypted_number = $_GET['token'];

    // Veritabanından şifrelenmiş numarayı çözerek kupon numarasını al
    $sql = "SELECT coupon_number FROM coupons WHERE encrypted_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $encrypted_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $coupon_number = $row['coupon_number'];
        $file_path = "generated_coupons/coupon_$coupon_number.jpg";

        if (file_exists($file_path)) {
            header('Content-Type: image/jpeg');
            readfile($file_path);
        } else {
            echo "Coupon not found.";
        }
    } else {
        echo "Invalid token.";
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
$conn->close();
?>
