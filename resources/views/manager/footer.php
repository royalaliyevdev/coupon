</div>
<footer class="footer mb-0 mt-5  py-3" style="position: fixed">
    <div class="container text-center">
        <span class="text-muted">Sistem
            <a href="https://lumusoft.com/az" target="_blank">
                <img src="https://lumusoft.com/assets/images/logo-lg.svg" alt="Lumusoft Logo" style="height: 14px;">
            </a>
            tərəfindən yaradıldı.
        </span>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script src="/manager/scan.js"></script>
<script>
    $(document).ready(function(){
        // Telefon numarası maskesi
        $("#phone").mask("(000) 000 00 00", {
            placeholder: "(___) ___ __ __"
        });
    });
</script>
</body>
</html>
