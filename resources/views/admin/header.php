<?php
require dirname(__DIR__, 3) . '/config.php';
require dirname(__DIR__, 3) . '/session_manager.php';
checkAdminAccess();

$base_url = '/coupon/admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/../resources/style/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url; ?>/index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    User
                </a>
                <div class="dropdown-menu" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?php echo $base_url; ?>/add_user.php">Add User</a>
                    <a class="dropdown-item" href="<?php echo $base_url; ?>/list_users.php">List Users</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="couponDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Coupons
                </a>
                <div class="dropdown-menu" aria-labelledby="couponDropdown">
                    <a class="dropdown-item" href="<?php echo $base_url; ?>/form.php">Add Coupon</a>
                    <a class="dropdown-item" href="<?php echo $base_url; ?>/list.php">List Coupons</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="storeDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Stores
                </a>
                <div class="dropdown-menu" aria-labelledby="storeDropdown">
                    <a class="dropdown-item" href="<?php echo $base_url; ?>/add_store.php">Add Store</a>
                    <a class="dropdown-item" href="<?php echo $base_url; ?>/list_stores.php">List Stores</a>
                </div>
            </li>
        </ul>
    </div>
    <a href="<?php echo $base_url; ?>/../logout.php" class="btn btn-danger">Logout</a>
</nav>
<div class="container mt-4">
