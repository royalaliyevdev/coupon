document.addEventListener("DOMContentLoaded", function() {
    function onScanSuccess(qrCodeMessage) {
        const urlParts = qrCodeMessage.split('/');
        const couponNumber = urlParts[urlParts.length - 1];

        if (couponNumber) {
            document.getElementById('qr-reader-results').innerText = "QR Code Detected: " + qrCodeMessage;
            document.getElementById('coupon_number').value = couponNumber;

            // Fetch coupon details using AJAX
            fetch(`fetch_coupon.php?coupon_number=${couponNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('store').value = data.coupon.store_id || '';
                        document.getElementById('name').value = data.coupon.name || '';
                        document.getElementById('phone').value = data.coupon.phone || '';
                        document.getElementById('car_brand').value = data.coupon.car_brand || '';
                        document.getElementById('fuel_type').value = data.coupon.fuel_type || '';

                        if (data.coupon.status === 'active') {
                            document.getElementById('store').disabled = true;
                            document.getElementById('name').disabled = true;
                            document.getElementById('phone').disabled = true;
                            document.getElementById('car_brand').disabled = true;
                            document.getElementById('fuel_type').disabled = true;
                            if (!document.getElementById('activatedMessage')) {
                                document.getElementById('store').insertAdjacentHTML('beforebegin', '<button id="activatedMessage" class="btn btn-success btn-block mb-2">Aktivləşdirilib</button>');
                            }
                            document.getElementById('submitButton').style.display = 'none';
                        } else {
                            document.getElementById('store').disabled = false;
                            document.getElementById('name').disabled = false;
                            document.getElementById('phone').disabled = false;
                            document.getElementById('car_brand').disabled = false;
                            document.getElementById('fuel_type').disabled = false;
                            if (document.getElementById('activatedMessage')) {
                                document.getElementById('activatedMessage').remove();
                            }
                            document.getElementById('submitButton').style.display = 'block';
                        }

                        document.getElementById('couponForm').style.display = 'block';
                    } else {
                        alert("Coupon not found.");
                        document.getElementById('couponForm').style.display = 'none';
                        if (document.getElementById('activatedMessage')) {
                            document.getElementById('activatedMessage').remove();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('couponForm').style.display = 'none';
                    if (document.getElementById('activatedMessage')) {
                        document.getElementById('activatedMessage').remove();
                    }
                });
        } else {
            alert("Invalid QR Code");
            document.getElementById('couponForm').style.display = 'none';
            if (document.getElementById('activatedMessage')) {
                document.getElementById('activatedMessage').remove();
            }
        }
    }

    function onScanError(errorMessage) {
        // Handle scan error
    }

    // Initialize the scanner
    const html5QrCode = new Html5Qrcode("qr-reader");

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            let cameraId = devices[0].id; // Default to the first camera
            if (devices.length >= 2) {
                cameraId = devices[1].id; // Use the second camera if available
            }
            html5QrCode.start(
                cameraId,
                {
                    fps: 10,    // Optional, frame per seconds for qr code scanning
                    qrbox: 250  // Optional, if you want bounded box UI
                },
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error("Error starting the QR code scanner:", err);
            });
        }
    }).catch(err => {
        console.error("Error getting cameras:", err);
    });

    // Initially hide the coupon form
    document.getElementById('couponForm').style.display = 'none';
});