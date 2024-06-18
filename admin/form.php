<?php
include '../resources/views/admin/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Coupon Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Admin Coupon Form</h2>
    <form action="submit.php" method="post">
        <div class="form-group">
            <label for="coupon_number">Number of Coupons</label>
            <input type="number" class="form-control" id="number_of_coupons" name="number_of_coupons" min="1" required>
        </div>
        <div class="form-group">
            <label for="store">Store (Optional)</label>
            <select class="form-control" id="store" name="store_id">
                <option value="">Select Store</option>
                <?php
                require '../config.php';
                $sql = "SELECT id, name FROM stores";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="car_brand" name="car_brand" placeholder="Car Brand">
        </div>
        <div class="form-group">
            <select class="form-control" id="fuel_type" name="fuel_type">
                <option value="">Select Fuel Type</option>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Coupons</button>
    </form>
</div>
</body>
</html>
<?php include '../resources/views/admin/footer.php'; ?>