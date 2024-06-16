<?php
require '../config.php';

if (isset($_GET['coupon_number'])) {
    $coupon_number = intval($_GET['coupon_number']);
    $sql = "SELECT c.coupon_number, s.name as store_name, c.name, c.phone, c.car_brand, c.fuel_type, c.status, c.used
            FROM coupons c
            LEFT JOIN stores s ON c.store_id = s.id
            WHERE c.coupon_number = $coupon_number";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $coupon = $result->fetch_assoc();
    } else {
        echo "Coupon not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Coupon</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Coupon Details</h2>
    <form action="update_coupon.php" method="post">
        <input type="hidden" name="coupon_number" value="<?php echo $coupon['coupon_number']; ?>">
        <div class="form-group">
            <label for="store">Store</label>
            <select class="form-control" id="store" name="store_id">
                <option value="">Select Store</option>
                <?php
                $stores_sql = "SELECT id, name FROM stores";
                $stores_result = $conn->query($stores_sql);
                while ($store = $stores_result->fetch_assoc()) {
                    $selected = $store['id'] == $coupon['store_id'] ? 'selected' : '';
                    echo "<option value='" . $store['id'] . "' $selected>" . $store['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $coupon['name']; ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $coupon['phone']; ?>">
        </div>
        <div class="form-group">
            <label for="car_brand">Car Brand</label>
            <input type="text" class="form-control" id="car_brand" name="car_brand" value="<?php echo $coupon['car_brand']; ?>">
        </div>
        <div class="form-group">
            <label for="fuel_type">Fuel Type</label>
            <select class="form-control" id="fuel_type" name="fuel_type">
                <option value="">Select Fuel Type</option>
                <option value="Petrol" <?php echo $coupon['fuel_type'] == 'Petrol' ? 'selected' : ''; ?>>Petrol</option>
                <option value="Diesel" <?php echo $coupon['fuel_type'] == 'Diesel' ? 'selected' : ''; ?>>Diesel</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="passive" <?php echo $coupon['status'] == 'passive' ? 'selected' : ''; ?>>Passive</option>
                <option value="active" <?php echo $coupon['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
            </select>
        </div>
        <div class="form-group">
            <label for="used">Used</label>
            <select class="form-control" id="used" name="used">
                <option value="no" <?php echo $coupon['used'] == 'no' ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo $coupon['used'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Coupon</button>
    </form>
</div>
</body>
</html>
