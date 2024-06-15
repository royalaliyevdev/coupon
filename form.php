<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Coupon Ticket Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Coupon Ticket Form</h2>
    <?php
    require 'config.php';

    // Get the current coupon number and increment it
    $result = $conn->query("SELECT last_coupon_number FROM coupon_numbers WHERE id=1");
    $row = $result->fetch_assoc();
    $coupon_number = $row['last_coupon_number'] + 1;
    ?>
    <form action="submit.php" method="post">
        <div class="form-group">
            <label for="coupon_number">Coupon Number</label>
            <input type="text" class="form-control" id="coupon_number" name="coupon_number" value="<?php echo $coupon_number; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="car_brand">Car Brand</label>
            <input type="text" class="form-control" id="car_brand" name="car_brand" required>
        </div>
        <div class="form-group">
            <label for="fuel_type">Fuel Type</label>
            <select class="form-control" id="fuel_type" name="fuel_type" required>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
