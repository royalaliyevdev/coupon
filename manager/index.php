<?php include '../resources/views/manager/header.php'; ?>




    <div class="mt-5 mb-5 pb-5" id="couponDetails" style="position: relative; ">
        <div id="qr-reader" style="width:100%;"></div>
        <div id="qr-reader-results"></div>

        <form id="couponForm" method="post" action="update.php" >
            <input type="hidden" id="coupon_number" name="coupon_number">
            <div class="form-group">
                <select class="form-control" id="store" name="store_id" required>
                    <option value="">Mağazanı seç</option>
                    <?php
                    session_start(); // Oturumu başlat
                    require '../config.php';
                    $selected_store = isset($_SESSION['selected_store']) ? $_SESSION['selected_store'] : '';
                    $sql = "SELECT id, name FROM stores";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row['id'] == $selected_store) ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control uponInput" id="name" name="name" placeholder="Ad" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control uponInput" id="phone" name="phone" placeholder="Mobil nömrə" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control uponInput" id="car_brand" name="car_brand" placeholder="Marka, model, il" required>
            </div>
            <div class="form-group">
                <select class="form-control uponInput" id="fuel_type" name="fuel_type" required>
                    <option value="">Yanacaq tipi </option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                </select>
            </div>
            <button type="submit" class="btn uponButton" id="submitButton">Saxla və Aktivləşdir</button>
        </form>
    </div>



<?php include '../resources/views/manager/footer.php'; ?>
