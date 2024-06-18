<?php
include '../resources/views/admin/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_number = intval($_POST['coupon_number']);
    $store_id = !empty($_POST['store_id']) ? intval($_POST['store_id']) : 'NULL';
    $name = !empty($_POST['name']) ? "'" . $conn->real_escape_string($_POST['name']) . "'" : 'NULL';
    $phone = !empty($_POST['phone']) ? "'" . $conn->real_escape_string($_POST['phone']) . "'" : 'NULL';
    $car_brand = !empty($_POST['car_brand']) ? "'" . $conn->real_escape_string($_POST['car_brand']) . "'" : 'NULL';
    $fuel_type = !empty($_POST['fuel_type']) ? "'" . $conn->real_escape_string($_POST['fuel_type']) . "'" : 'NULL';
    $status = "'" . $conn->real_escape_string($_POST['status']) . "'";
    $used = "'" . $conn->real_escape_string($_POST['used']) . "'";

    $sql = "UPDATE coupons SET store_id = $store_id, name = $name, phone = $phone, car_brand = $car_brand, fuel_type = $fuel_type, status = $status, used = $used WHERE coupon_number = $coupon_number";

    if ($conn->query($sql) === TRUE) {
        echo "Coupon updated successfully";
    } else {
        echo "Error updating coupon: " . $conn->error;
    }

    $conn->close();
    header("Location: list.php");
    exit;
}
?>
