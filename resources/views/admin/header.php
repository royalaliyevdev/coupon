<?php
header('Content-Type: text/html; charset=utf-8');
require dirname(__DIR__, 3) . '/system/routes/helpers.php';
require dirname(__DIR__, 3) . '/config.php';
require dirname(__DIR__, 3) . '/session_manager.php';

checkAdminAccess();

$base_url = '/admin';
$coupon_url= '/app/coupon';
$main_url = '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/../resources/style/style.css?v=1<?=rand(1,200)?>">

</head>
<body>
<div class="hamburger-icon" onclick="toggleNavbar()">
   <span  alt="Menu" width="20" height="20">☰ menu</span>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light w-100 topnavbar" >
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: space-evenly;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url; ?>/index.php">Home</a>
            </li>
            <!-- additional nav items -->
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?php echo $base_url; ?>/../logout.php" class="btn btn-danger">Logout</a>
            </li>
            <!-- additional nav items -->
        </ul>
    </div>
</nav>


<nav class="navbar-vertical">
    <div class="logo">
        <img src="<?php echo $base_url; ?>/../resources/images/Upon-logo-full-white.png" alt="Logo">
    </div>
    <a href="<?php echo $base_url; ?>/index.php" class="nav-link">Home</a>
    <a href="javascript:void(0)" class="dropdown-btn">User
        <img src="<?php echo $base_url; ?>/../resources/images/select-icon.svg" class="svg-icon">
    </a>
    <div class="dropdown-container">
        <a href="<?php echo $base_url; ?>/add_user.php">Add User</a>
        <a href="<?php echo $base_url; ?>/list_users.php">List Users</a>
    </div>
    <a href="javascript:void(0)" class="dropdown-btn">Coupons
        <img src="<?php echo $base_url; ?>/../resources/images/select-icon.svg" class="svg-icon">
    </a>
    <div class="dropdown-container">
        <a href="<?php echo $coupon_url; ?>/form.php">Add Coupon</a>
        <a href="<?php echo $coupon_url; ?>/list.php">List Coupons</a>
    </div>
    <a href="javascript:void(0)" class="dropdown-btn">Stores
        <img src="<?php echo $base_url; ?>/../resources/images/select-icon.svg" class="svg-icon">
    </a>
    <div class="dropdown-container">
        <a href="<?php echo $base_url; ?>/add_store.php">Add Store</a>
        <a href="<?php echo $base_url; ?>/list_stores.php">List Stores</a>
    </div>
</nav>

<div class="container mt-4 pt-5 AdmingeneralContainer">

