<?php
require 'session_manager.php';

// Eğer oturum açılmamışsa login sayfasına yönlendir
if (!isset($_SESSION['user_type'])) {
    header("Location: ../login.php");
    exit();
}
?>