</div>

<footer  class="footer mb-0 mt-5 py-3" style="position: fixed">
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    var dropdowns = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }

    function toggleNavbar() {
        var navbar = document.querySelector('.navbar-vertical');
        navbar.classList.toggle('open');
    }
</script>

</body>
</html>
