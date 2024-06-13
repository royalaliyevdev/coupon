<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coupon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function convertToLatin($string) {
    $azerbaijan = ['Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'Ə', 'ç', 'ş', 'ğ', 'ü', 'ı', 'ö', 'ə'];
    $latin = ['C', 'S', 'G', 'U', 'I', 'O', 'A', 'c', 's', 'g', 'u', 'i', 'o', 'a'];
    return str_replace($azerbaijan, $latin, $string);
}

$coupon_number = $_POST['coupon_number'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$car_model = $_POST['car_model'];

$name_latin = convertToLatin($name);

$sql = "INSERT INTO registered (coupon_number, name, phone, car_model) VALUES ('$coupon_number', '$name', '$phone', '$car_model')";

if ($conn->query($sql) === TRUE) {
    $sms_user = "bardahl456_servis";
    $sms_password = "bardahl456s";
    $sms_text = "Hormetli $name_latin, qeydiyyatdan kecdiniz! Kupon kodunuz: $coupon_number";
    $sms_gsm = $phone;

    $url = "http://www.poctgoyercini.com/api_http/sendsms.asp";
    $post_fields = http_build_query([
        'user' => $sms_user,
        'password' => $sms_password,
        'gsm' => $sms_gsm,
        'text' => $sms_text
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        echo "SMS gönderilirken hata oluştu.";
    }

    header("Location: success.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
