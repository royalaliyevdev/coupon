<?php include '../resources/views/store/header.php'; ?>



    <div class="mt-5" id="couponDetails">
        <h2>Skan edin</h2>
        <div id="qr-reader" style="width:100%;"></div>
        <div id="qr-reader-results"></div>

        <form id="couponForm" method="post" action="update_coupon.php" enctype="multipart/form-data">
            <input type="hidden" id="coupon_number" name="coupon_number">
            <div class="form-group">
                <label for="product_image">Məhsulun şəkli</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input uponInput" id="product_image" name="product_image" accept="image/*" capture="environment" required>
                    <label class="custom-file-label" for="product_image">Select Image</label>
                </div>
            </div>
            <div class="form-group">
                <label for="price">Cəmi məbləğ</label>
                <input type="number" class="form-control uponInput" id="price" name="price" placeholder="Endirimsiz məbləğ" required>
            </div>
            <button type="submit" class="btn uponButton" id="submitButton">Kuponu istifadə et</button>
        </form>
    </div>

<script>
    const storeId = <?php echo $store_id; ?>;
</script> 
<script>
    // Update the label of the file input with the selected file name
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("product_image").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    });
</script>
<?php include '../resources/views/store/footer.php'; ?>
