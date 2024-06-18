<?php
require dirname(__DIR__, 3) . '/config.php';
require dirname(__DIR__, 3) . '/session_manager.php';
checkManagerAccess();

$base_url = '/coupon/manager';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manager Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/../resources/style/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Manager Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url; ?>/index.php">Home</a>
            </li>
        </ul>
    </div>
    <a href="<?php echo $base_url; ?>/../logout.php" class="btn btn-danger">Logout</a>
</nav>
<div class="container mt-4">
