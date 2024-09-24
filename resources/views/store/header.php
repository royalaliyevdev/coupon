<?php
header('Content-Type: text/html; charset=utf-8');
require dirname(__DIR__, 3) . '/config.php';
require dirname(__DIR__, 3) . '/session_manager.php';
checkStoreAccess();

$store_id = $_SESSION['store_id'];

$base_url = '/store';

$module_sql = "SELECT status FROM modules WHERE name = 'Store'";
$module_result = $conn->query($module_sql);
$module = $module_result->fetch_assoc();

if ($module['status'] !== 'enabled') {
    echo "Store module is disabled.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mağaza Paneli</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/../resources/style/style.css?v=1<?=rand(1,200)?>">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Browse";
        }
        .custom-file-label::after {
            content: "Camera";
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="logo mobileDisplayBlock">
        <img src="/icon-192x192.png" alt="Logo" style="width: 35px">
    </div>
    <a class="navbar-brand" href="#"> Mağaza Paneli</a>
    <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url; ?>/index.php">Skaner</a>
            </li>
        </ul>
    </div>-->
    <a href="<?php echo $base_url; ?>/../logout.php" class="btn btn-danger">Çıxış</a>
</nav>
<div class="container mt-4">

