<?php include '../resources/views/store/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Store Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Browse";
        }
        .custom-file-label::after {
            content: "Camera";
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>QR Code Scanner</h2>
    <div id="qr-reader" style="width:100%;"></div>
    <div id="qr-reader-results"></div>

    <div class="mt-5" id="couponDetails">
        <form id="couponForm" method="post" action="update_coupon.php" enctype="multipart/form-data">
            <input type="hidden" id="coupon_number" name="coupon_number">
            <div class="form-group">
                <label for="product_image">Məhsulun şəkli</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="product_image" name="product_image" accept="image/*" capture="environment" required>
                    <label class="custom-file-label" for="product_image">Select Image</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="submitButton">Use Coupon</button>
        </form>
    </div>
</div>

<script>
    const storeId = <?php echo $store_id; ?>;
</script>
<script src="scan.js"></script>
<script>
    // Update the label of the file input with the selected file name
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("product_image").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    });
</script>
</body>
</html>
<?php include '../resources/views/store/footer.php'; ?>
