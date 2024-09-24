document.addEventListener("DOMContentLoaded", function() {
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Skandan keçmə nəticəsi: ${decodedText}`, decodedResult);
        const urlParts = decodedText.split('/');
        const token = urlParts[urlParts.length - 1];

        if (token) {
            document.getElementById('qr-reader-results').innerText = "QR Kodu Aşkarlanıb: " + decodedText;

            // Kupon detalları AJAX ilə alınır
            fetch(`fetch_coupon.php?token=${token}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.coupon.used === 'yes') {
                            document.getElementById('qr-reader-results').innerHTML = `
                                <div class="alert alert-danger" role="alert">
                                    Bu kupon istifadə olunub!
                                </div>`;
                            document.getElementById('couponForm').style.display = 'none';
                        } else if (data.coupon.status === 'active' && data.coupon.store_id == storeId) {
                            document.getElementById('coupon_number').value = data.coupon.coupon_number;
                            document.getElementById('couponForm').style.display = 'block';
                        } else {
                            alert("Kupon ya istifadə olunub, ya da bu mağazaya aid deyil.");
                        }
                    } else {
                        alert("Kupon tapılmadı.");
                        document.getElementById('couponForm').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Xəta:', error);
                    document.getElementById('couponForm').style.display = 'none';
                });
        } else {
            alert("Etibarsız QR Kodu");
            document.getElementById('couponForm').style.display = 'none';
        }
    }

    function onScanFailure(error) {
        console.warn(`QR xətası = ${error}`);
    }

    function startQrScanner() {
        const html5QrCode = new Html5Qrcode("qr-reader");
        const config = { fps: 10, qrbox: 250, aspectRatio: 1.0 };

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                let cameraId = devices[0].id; // Default olaraq ilk kameranı seç
                if (devices.length >= 2) {
                    cameraId = devices[1].id; // Əgər mövcudsa ikinci kameranı istifadə et
                }
                html5QrCode.start(cameraId, config, onScanSuccess, onScanFailure)
                    .catch(err => {
                        console.error("QR kod skanını başlatma xətası:", err);
                    });
            }
        }).catch(err => {
            console.error("Kameraları əldə etmə xətası:", err);
        });
    }

    // Kamera icazəsinin yoxlanması
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            // Yalnız icazəni yoxlamaq üçün stream dərhal dayandırılır
            stream.getTracks().forEach(track => track.stop());
            startQrScanner();
        })
        .catch(err => {
            console.error("Kameraya giriş xətası:", err);
            alert("Zəhmət olmasa, kamera icazəsini verin və digər tətbiqlərin kameradan istifadə etmədiyinə əmin olun.");
        });

    // Əvvəlcə kupon formunu gizlədin
    document.getElementById('couponForm').style.display = 'none';
});
