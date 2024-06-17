<?php
require '../config.php';
require '../phpqrcode/qrlib.php';
require '../vendor/autoload.php';

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader\PdfReader;

$prefix = "lumusoft";
$number_of_coupons = $_POST['number_of_coupons'];
$store_id = isset($_POST['store_id']) && !empty($_POST['store_id']) ? $_POST['store_id'] : 'NULL';
$name = !empty($_POST['name']) ? "'" . $conn->real_escape_string($_POST['name']) . "'" : 'NULL';
$phone = !empty($_POST['phone']) ? "'" . $conn->real_escape_string($_POST['phone']) . "'" : 'NULL';
$car_brand = !empty($_POST['car_brand']) ? "'" . $conn->real_escape_string($_POST['car_brand']) . "'" : 'NULL';
$fuel_type = !empty($_POST['fuel_type']) ? "'" . $conn->real_escape_string($_POST['fuel_type']) . "'" : 'NULL';
$status = isset($_POST['status']) ? $_POST['status'] : 'passive';
$used = isset($_POST['used']) ? $_POST['used'] : 'no';

for ($i = 0; $i < $number_of_coupons; $i++) {
    // Generate a new coupon number
    $result = $conn->query("SELECT last_coupon_number FROM coupon_numbers WHERE id=1");
    $row = $result->fetch_assoc();
    $coupon_number = $row['last_coupon_number'] + 1;

    // Encrypt the coupon number
    $encrypted_number = md5($prefix . $coupon_number);

    // Insert data into the database
    $sql = "INSERT INTO coupons (coupon_number, store_id, name, phone, car_brand, fuel_type, status, used, encrypted_number)
            VALUES ('$coupon_number', $store_id, $name, $phone, $car_brand, $fuel_type, '$status', '$used', '$encrypted_number')";

    if ($conn->query($sql) === TRUE) {
        // Update the coupon number
        $conn->query("UPDATE coupon_numbers SET last_coupon_number = $coupon_number WHERE id = 1");

        // Generate QR code with the encrypted coupon number
        $url = "https://yourdomain.com/coupon/$encrypted_number";
        $qr_file = '../qrcodes/' . $coupon_number . '.png';
        QRcode::png($url, $qr_file);

        // Load the base image
        $base_image_path = '../discount-ticket.webp';  // Assuming the image is in the main directory
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
        $final_image_path = '../generated_coupons/coupon_' . $coupon_number . '.jpg';
        imagejpeg($image, $final_image_path, 100);

        // Free up memory
        imagedestroy($image);
        imagedestroy($qr_code_image);
        imagedestroy($resized_qr_code_image);

        // Rotate the final image 90 degrees
        $rotated_image_path = '../generated_coupons/rotated_coupon_' . $coupon_number . '.jpg';
        $rotated_image = imagerotate(imagecreatefromjpeg($final_image_path), 90, 0);
        imagejpeg($rotated_image, $rotated_image_path, 100);
        imagedestroy($rotated_image);

        // Convert the rotated image to A4 PDF in portrait orientation
        $pdf = new Fpdi();
        $pdf->AddPage('P');  // 'P' for portrait
        $pdf->Image($rotated_image_path, 0, 0, 210, 99);  // Place the rotated image at the top of the A4 page
        $pdf_output_path = '../generated_coupons/coupon_' . $coupon_number . '.pdf';
        $pdf->Output($pdf_output_path, 'F');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: list.php");
exit;
?>
