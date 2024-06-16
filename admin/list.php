<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>List Coupons</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>List of Coupons</h2>
    <form action="bulk_action.php" method="post">
        <div class="form-row align-items-center mb-3">
            <div class="col-auto">
                <input type="number" class="form-control mb-2" id="start_number" name="start_number" placeholder="Start Number">
            </div>
            <div class="col-auto">
                <input type="number" class="form-control mb-2" id="end_number" name="end_number" placeholder="End Number">
            </div>
            <div class="col-auto">
                <button type="button" id="select_range" class="btn btn-info mb-2">Select Range</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><input type="checkbox" id="select_all"></th>
                <th>Coupon Number</th>
                <th>Store</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Car Brand</th>
                <th>Fuel Type</th>
                <th>Status</th>
                <th>Used</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="coupon_table_body">
            <?php
            require '../config.php';
            $sql = "SELECT c.coupon_number, s.name as store_name, c.name, c.phone, c.car_brand, c.fuel_type, c.status, c.used
                        FROM coupons c
                        LEFT JOIN stores s ON c.store_id = s.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='coupon_numbers[]' value='" . $row['coupon_number'] . "'></td>";
                    echo "<td>" . $row['coupon_number'] . "</td>";
                    echo "<td>" . ($row['store_name'] ? $row['store_name'] : '') . "</td>";
                    echo "<td>" . ($row['name'] ? $row['name'] : '') . "</td>";
                    echo "<td>" . ($row['phone'] ? $row['phone'] : '') . "</td>";
                    echo "<td>" . ($row['car_brand'] ? $row['car_brand'] : '') . "</td>";
                    echo "<td>" . ($row['fuel_type'] ? $row['fuel_type'] : '') . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['used'] . "</td>";
                    echo "<td>";
                    echo "<a href='view_coupon.php?coupon_number=" . $row['coupon_number'] . "' class='btn btn-primary btn-sm'>View</a> ";
                    echo "<a href='download_coupon.php?coupon_number=" . $row['coupon_number'] . "' class='btn btn-secondary btn-sm'><i class='fas fa-file-pdf'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No coupons found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <div class="form-group">
            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete Selected</button>
            <button type="submit" name="action" value="download" class="btn btn-primary">Download Selected as PDF</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('select_all').onclick = function() {
        var checkboxes = document.getElementsByName('coupon_numbers[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    document.getElementById('select_range').onclick = function() {
        var startNumber = parseInt(document.getElementById('start_number').value);
        var endNumber = parseInt(document.getElementById('end_number').value);
        if (!isNaN(startNumber) && !isNaN(endNumber) && startNumber <= endNumber) {
            var checkboxes = document.getElementsByName('coupon_numbers[]');
            for (var checkbox of checkboxes) {
                var couponNumber = parseInt(checkbox.value);
                checkbox.checked = couponNumber >= startNumber && couponNumber <= endNumber;
            }
        }
    }

    document.getElementById('start_number').onchange = document.getElementById('end_number').onchange = function() {
        var startNumber = parseInt(document.getElementById('start_number').value);
        var endNumber = parseInt(document.getElementById('end_number').value);
        if (!isNaN(startNumber) && !isNaN(endNumber) && startNumber <= endNumber) {
            var checkboxes = document.getElementsByName('coupon_numbers[]');
            for (var checkbox of checkboxes) {
                var couponNumber = parseInt(checkbox.value);
                checkbox.checked = couponNumber >= startNumber && couponNumber <= endNumber;
            }
        }
    }
</script>

</body>
</html>
