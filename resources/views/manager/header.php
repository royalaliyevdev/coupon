<?php
header('Content-Type: text/html; charset=utf-8');
require dirname(__DIR__, 3) . '/config.php';
require dirname(__DIR__, 3) . '/session_manager.php';
checkManagerAccess();

$base_url = '/manager';

$module_sql = "SELECT status FROM modules WHERE name = 'Manager'";
$module_result = $conn->query($module_sql);
$module = $module_result->fetch_assoc();

if ($module['status'] !== 'enabled') {
    echo "Manager module is disabled.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Menecer Paneli</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/../resources/style/style.css?v=1<?=rand(1,200)?>">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="logo mobileDisplayBlock">
        <img src="/icon-192x192.png" alt="Logo" style="width: 35px">
    </div>
    <a class="navbar-brand" href="#">Menecer Paneli</a>
    <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url; ?>/index.php">Home</a>
            </li>
        </ul>
    </div>-->
    <a href="<?php echo $base_url; ?>/../logout.php" class="btn btn-danger">Çıxış</a>
</nav>
<div class="container mt-4 mb-5" style="position: relative">
