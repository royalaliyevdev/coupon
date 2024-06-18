<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_number = $_POST['coupon_number'];
    $store_id = $_POST['store_id'];
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']); // Telefon numarasını trimle
    $car_brand = $_POST['car_brand'];
    $fuel_type = $_POST['fuel_type'];

    // Name alanını Latin karakterlere dönüştür
    $name_latin = convertToLatin($name);

    // Kuponu güncelle ve aktiv hale getir
    $sql = "UPDATE coupons SET store_id = ?, name = ?, phone = ?, car_brand = ?, fuel_type = ?, status = 'active' WHERE coupon_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssi', $store_id, $name, $phone, $car_brand, $fuel_type, $coupon_number);

    if ($stmt->execute()) {
        // Kupon başarıyla güncellenirse, SMS gönder
        sendSMS($name_latin, $coupon_number, $phone);
        echo "Coupon updated and activated successfully.";
    } else {
        echo "Error updating coupon: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}

function convertToLatin($string) {
    $azerbaijan = ['Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'Ə', 'ç', 'ş', 'ğ', 'ü', 'ı', 'ö', 'ə'];
    $latin = ['C', 'S', 'G', 'U', 'I', 'O', 'A', 'c', 's', 'g', 'u', 'i', 'o', 'a'];
    return str_replace($azerbaijan, $latin, $string);
}

function sendSMS($name_latin, $coupon_number, $phone) {
    $sms_user = "bardahl456_servis";
    $sms_password = "bardahl456s";
    $sms_text = "Hormetli $name_latin, qeydiyyatdan kecdiniz! Kupon kodunuz: $coupon_number";
    $sms_gsm = formatPhoneNumber($phone);

    $url = "http://www.poctgoyercini.com/api_http/sendsms.asp";
    $post_fields = http_build_query([
        'user' => $sms_user,
        'password' => $sms_password,
        'gsm' => $sms_gsm,
        'text' => $sms_text
    ]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $post_fields,
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        // Hata durumunda yapılacak işlemler
        echo "Error sending SMS.";
    }
}

function formatPhoneNumber($phone) {
    // Masked phone number formatından temizleyerek sadece rakamları al
    return preg_replace('/[^0-9]/', '', $phone);
}
?>
