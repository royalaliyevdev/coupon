<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_number = $_POST['coupon_number'];
    $store_id = $_POST['store_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $car_brand = $_POST['car_brand'];
    $fuel_type = $_POST['fuel_type'];

    $sql = "UPDATE coupons SET store_id = '$store_id', name = '$name', phone = '$phone', car_brand = '$car_brand', fuel_type = '$fuel_type', status = 'active' WHERE coupon_number = '$coupon_number'";

    if ($conn->query($sql) === TRUE) {
        echo "Coupon updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
    header("Location: index.php");
    exit;
}
?>
