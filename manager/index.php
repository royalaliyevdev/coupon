<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manager QR Scanner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div id="qr-reader" style="width:100%;"></div>
    <div id="qr-reader-results"></div>

    <div class="mt-5" id="couponDetails">
        <form id="couponForm" method="post" action="update.php">
            <input type="hidden" id="coupon_number" name="coupon_number">
            <div class="form-group">
                <select class="form-control" id="store" name="store_id" required>
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
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="car_brand" name="car_brand" placeholder="Car Brand" required>
            </div>
            <div class="form-group">
                <select class="form-control" id="fuel_type" name="fuel_type" required>
                    <option value="">Select Fuel Type</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" id="submitButton">Save and Activate</button>
        </form>
    </div>
</div>

<script src="scan.js"></script>
</body>
</html>
