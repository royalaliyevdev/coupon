<?php
require 'config.php';
require 'phpqrcode/qrlib.php';
require 'vendor/autoload.php';  // Including Composer's autoload file

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader\PdfReader;

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
    $url = "https://192.168.31.55/coupon/coupon/$coupon_number";
    $qr_file = 'qrcodes/' . $coupon_number . '.png';
    QRcode::png($url, $qr_file);

    // Load the base image
    $base_image_path = 'discount-ticket.webp';  // Assuming the image is in the main directory
    $image = imagecreatefromwebp($base_image_path);

    // Load the QR code image
    $qr_code_image = imagecreatefrompng($qr_file);

    // Resize the QR code to 270 pixels width while maintaining the aspect ratio
    $qr_width = imagesx($qr_code_image);
    $qr_height = imagesy($qr_code_image);
    $new_qr_width = 270;
    $new_qr_height = intval($qr_height * ($new_qr_width / $qr_width));
    $resized_qr_code_image = imagecreatetruecolor($new_qr_width, $new_qr_height);
    imagecopyresampled($resized_qr_code_image, $qr_code_image, 0, 0, 0, 0, $new_qr_width, $new_qr_height, $qr_width, $qr_height);

    // Determine the position to paste the QR code (bottom left of the image)
    $qr_position_x = 25; // Position 25 pixels from the left
    $qr_position_y = imagesy($image) - $new_qr_height - 25; // Position 25 pixels from the bottom

    // Paste the QR code onto the base image
    imagecopy($image, $resized_qr_code_image, $qr_position_x, $qr_position_y, 0, 0, $new_qr_width, $new_qr_height);

    // Save the modified image as JPEG
    $final_image_path = 'generated_coupons/coupon_' . $coupon_number . '.jpg';
    imagejpeg($image, $final_image_path, 100);

    // Free up memory
    imagedestroy($image);
    imagedestroy($qr_code_image);
    imagedestroy($resized_qr_code_image);

    // Rotate the final image 90 degrees
    $rotated_image_path = 'generated_coupons/rotated_coupon_' . $coupon_number . '.jpg';
    $rotated_image = imagerotate(imagecreatefromjpeg($final_image_path), 90, 0);
    imagejpeg($rotated_image, $rotated_image_path, 100);
    imagedestroy($rotated_image);

    // Convert the rotated image to A4 PDF in portrait orientation
    $pdf = new Fpdi();
    $pdf->AddPage('P');  // 'P' for portrait
    $pdf->Image($rotated_image_path, 0, 0, 210, 99);  // Place the rotated image at the top of the A4 page
    $pdf_output_path = 'generated_coupons/coupon_' . $coupon_number . '.pdf';
    $pdf->Output($pdf_output_path, 'F');

    // Redirect to the show_coupon.php page
    header("Location: show_coupon.php?coupon_number=$coupon_number");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
