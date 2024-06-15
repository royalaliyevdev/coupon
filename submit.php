<?php
require 'config.php';
require 'phpqrcode/qrlib.php';

// Get data from the form
$coupon_number = $_POST['coupon_number'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$car_brand = $_POST['car_brand'];
$fuel_type = $_POST['fuel_type'];

// Insert data into the database
$sql = "INSERT INTO coupons (coupon_number, name, phone, car_brand, fuel_type)
VALUES ('$coupon_number', '$name', '$phone', '$car_brand', '$fuel_type')";

if ($conn->query($sql) === TRUE) {
    // Update the coupon number
    $conn->query("UPDATE coupon_numbers SET last_coupon_number = $coupon_number WHERE id = 1");

    // Generate QR code
    $url = "http://yourdomain.com/show_coupon.php?coupon_number=$coupon_number";
    $qr_file = 'qrcodes/' . $coupon_number . '.png';
    QRcode::png($url, $qr_file);

    // Load the base image
    $base_image_path = 'discount-ticket.webp';  // Assuming the image is in the main directory
    $image = imagecreatefromwebp($base_image_path);

    // Load the QR code image
    $qr_code_image = imagecreatefrompng($qr_file);

    // Resize the QR code to 300 pixels width while maintaining the aspect ratio
    $qr_width = imagesx($qr_code_image);
    $qr_height = imagesy($qr_code_image);
    $new_qr_width = 270;
    $new_qr_height = intval($qr_height * ($new_qr_width / $qr_width));
    $resized_qr_code_image = imagecreatetruecolor($new_qr_width, $new_qr_height);
    imagecopyresampled($resized_qr_code_image, $qr_code_image, 0, 0, 0, 0, $new_qr_width, $new_qr_height, $qr_width, $qr_height);

    // Determine the position to paste the QR code (bottom left of the image)
    $qr_position_x = 25; // Adjust according to the specific white area position
    $qr_position_y = imagesy($image) - $new_qr_height - 25; // Adjust according to the specific white area position

    // Paste the QR code onto the base image
    imagecopy($image, $resized_qr_code_image, $qr_position_x, $qr_position_y, 0, 0, $new_qr_width, $new_qr_height);

    // Save the modified image
    $final_image_path = 'generated_coupons/coupon_' . $coupon_number . '.webp';
    imagewebp($image, $final_image_path);

    // Free up memory
    imagedestroy($image);
    imagedestroy($qr_code_image);
    imagedestroy($resized_qr_code_image);

    // Redirect to the show_coupon.php page
    header("Location: show_coupon.php?coupon_number=$coupon_number");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
