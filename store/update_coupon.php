<?php include '../resources/views/store/header.php';

$store_id = $_SESSION['store_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_number = $_POST['coupon_number'];

    // Kuponun durumu ve mağaza id'si kontrolü
    $sql = "SELECT * FROM coupons WHERE coupon_number = ? AND store_id = ? AND status = 'active' AND used = 'no'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $coupon_number, $store_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Kupon bilgilerini al
        $coupon = $result->fetch_assoc();
        $coupon_image_path = '../generated_coupons/coupon_' . $coupon_number . '.jpg';

        if (file_exists($coupon_image_path)) {
            // Görüntüyü yükle
            $image = imagecreatefromjpeg($coupon_image_path);

            // Gri overlay ekle
            $overlay_color = imagecolorallocatealpha($image, 128, 128, 128, 50);
            imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $overlay_color);

            // Kırmızı renkte "İstifadə olunub!" yazısını ekle
            $stamp_text = "İstifadə olunub!";
            $font_size = 50;
            $font_color = imagecolorallocate($image, 255, 0, 0);
            $font_path = '../resources/style/fonts/arial.ttf'; // Font dosyası yolu
            $text_box = imagettfbbox($font_size, 0, $font_path, $stamp_text);
            $text_width = $text_box[2] - $text_box[0];
            $text_height = $text_box[7] - $text_box[1];
            $x = (imagesx($image) / 2) - ($text_width / 2);
            $y = (imagesy($image) / 2) - ($text_height / 2);
            imagettftext($image, $font_size, 0, $x, $y, $font_color, $font_path, $stamp_text);

            // Güncellenmiş görüntüyü kaydet
            imagejpeg($image, $coupon_image_path, 100);

            // Belleği boşalt
            imagedestroy($image);

            // Kuponun durumu ve kullanılmış bilgilerini güncelle
            $sql_update = "UPDATE coupons SET used = 'yes' WHERE coupon_number = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('i', $coupon_number);
            if ($stmt_update->execute()) {
                echo "Coupon marked as used and image updated successfully.";
            } else {
                echo "Error updating coupon status: " . $stmt_update->error;
            }
        } else {
            echo "Coupon image not found.";
        }
    } else {
        echo "Coupon not found or already used.";
    }
    $stmt->close();
}
$conn->close();
header("Location: index.php");
exit();
?>
