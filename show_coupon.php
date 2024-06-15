<?php
require 'config.php';

// Get the coupon number from the URL
$coupon_number = $_GET['coupon_number'];

// Fetch the coupon details from the database
$sql = "SELECT * FROM coupons WHERE coupon_number = '$coupon_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $coupon = $result->fetch_assoc();
} else {
    echo "Coupon not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Coupon Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Coupon Details</h2>
    <table class="table table-bordered">
        <tr>
            <th>Coupon Number</th>
            <td><?php echo $coupon['coupon_number']; ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?php echo $coupon['name']; ?></td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td><?php echo $coupon['phone']; ?></td>
        </tr>
        <tr>
            <th>Car Brand</th>
            <td><?php echo $coupon['car_brand']; ?></td>
        </tr>
        <tr>
            <th>Fuel Type</th>
            <td><?php echo $coupon['fuel_type']; ?></td>
        </tr>
        <tr>
            <th>Creation Date</th>
            <td><?php echo $coupon['creation_date']; ?></td>
        </tr>
    </table>
    <div class="mt-4">
        <h3>Coupon Image</h3>
        <img src="generated_coupons/coupon_<?php echo $coupon['coupon_number']; ?>.webp" alt="Coupon Image">
    </div>
</div>
</body>
</html>
