document.addEventListener("DOMContentLoaded", function() {
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`, decodedResult);
        const urlParts = decodedText.split('/');
        const token = urlParts[urlParts.length - 1];

        if (token) {
            document.getElementById('qr-reader-results').innerText = "QR Code Detected: " + decodedText;

            // Fetch coupon details using AJAX
            fetch(`fetch_coupon.php?token=${token}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.coupon.status === 'active' && data.coupon.store_id == storeId) {
                            document.getElementById('coupon_number').value = data.coupon.coupon_number;
                            document.getElementById('couponForm').style.display = 'block';
                        } else {
                            alert("Coupon is either used or does not belong to this store.");
                        }
                    } else {
                        alert("Coupon not found.");
                        document.getElementById('couponForm').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('couponForm').style.display = 'none';
                });
        } else {
            alert("Invalid QR Code");
            document.getElementById('couponForm').style.display = 'none';
        }
    }

    function onScanFailure(error) {

    }

    function startQrScanner() {
        const html5QrCode = new Html5Qrcode("qr-reader");
        const config = { fps: 10, qrbox: 250, aspectRatio: 1.0 };

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                let cameraId = devices[0].id; // Default to the first camera
                if (devices.length >= 2) {
                    cameraId = devices[1].id; // Use the second camera if available
                }
                html5QrCode.start(cameraId, config, onScanSuccess, onScanFailure)
                    .catch(err => {
                        console.error("Error starting the QR code scanner:", err);
                        // Hata durumunda tekrar dene
                        setTimeout(startQrScanner, 2000); // 2 saniye sonra tekrar dene
                    });
            }
        }).catch(err => {
            console.error("Error getting cameras:", err);
            // Hata durumunda tekrar dene
            setTimeout(startQrScanner, 2000); // 2 saniye sonra tekrar dene
        });
    }

    // Check for camera access permission
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            // Stop the stream immediately since we only needed to check permission
            stream.getTracks().forEach(track => track.stop());
            startQrScanner();
        })
        .catch(err => {
            console.error("Error accessing camera: ", err);
            alert("Please grant camera access and ensure no other application is using the camera.");
        });

    // Initially hide the coupon form
    document.getElementById('couponForm').style.display = 'none';
});
