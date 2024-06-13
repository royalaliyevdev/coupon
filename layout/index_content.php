<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bardahl Kampaniya</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mt-5">Kampaniyaya qoşul</h2>
    <form action="app/insert.php" method="post" class="mt-3">
        <div class="form-group">
            <label for="coupon_number">Kupon nömrəsi</label>
            <input type="text" class="form-control" id="coupon_number" name="coupon_number" required>
            <button type="button" class="btn btn-secondary mt-2" id="scan_qr_button">QR Kodu Tara</button>
        </div>
        <div id="qr-reader" style="width: 300px; display:none;"></div>
        <div class="form-group">
            <label for="name">Ad Soyad</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="phone">Mobil nömrə</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="car_model">Avtomobil marka, model və ili</label>
            <input type="text" class="form-control" id="car_model" name="car_model" required>
        </div>
        <button type="submit" class="btn btn-primary">Göndər</button>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#phone').mask('(000) 000-0000');

        $('#scan_qr_button').click(function(){
            $('#qr-reader').toggle();
            if ($('#qr-reader').is(':visible')) {
                const html5QrCode = new Html5Qrcode("qr-reader");
                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => {
                        $('#coupon_number').val(qrCodeMessage);
                        html5QrCode.stop();
                        $('#qr-reader').hide();
                    },
                    errorMessage => {
                        console.log(`QR kod tarama hatası: ${errorMessage}`);
                    }
                ).catch(err => {
                    console.log(`QR kod tarayıcı başlatılamadı: ${err}`);
                });
            }
        });
    });
</script>

</body>
</html>

