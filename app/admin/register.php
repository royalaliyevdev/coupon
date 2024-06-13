<?php
$title = "Admin";
include('../../layout/admin.php');
?>
<div class="container">
    <h2 class="mt-5">Kayıt Ol</h2>
    <form action="../register.php" method="post" class="mt-3">
        <div class="form-group">
            <label for="username">Kullanıcı Adı</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Şifre</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Rol</label>
            <select class="form-control" id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="manager">Menejer</option>
                <option value="store">Mağaza</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Kayıt Ol</button>
    </form>
</div>
</body>
</html>
