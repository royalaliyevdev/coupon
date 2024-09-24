<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Include header
include 'resources/views/header.php';

// Include the requested page content
switch ($page) {
    case 'portfolio':
        include 'resources/views/portfolio.php';
        break;
    case 'blog':
        include 'resources/views/blog.php';
        break;
    default:
        include 'resources/views/home.php';
        break;
}

// Include footer
include 'resources/views/footer.php';
