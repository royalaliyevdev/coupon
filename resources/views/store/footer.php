</div>
<footer  class="footer mb-0 mt-5  py-3" style="position: fixed">
    <div class="container text-center">
        <span class="text-muted">Sistem
            <a href="https://lumusoft.com/az" target="_blank">
                <img src="https://lumusoft.com/assets/images/logo-lg.svg" alt="Lumusoft Logo" style="height: 14px;">
            </a>
            tərəfindən yaradıldı.
        </span>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>

<script src="/store/scan.js"></script>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((registration) => {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, (error) => {
                    console.log('ServiceWorker registration failed: ', error);
                });
        });
    }
</script>
</body>
</html>
