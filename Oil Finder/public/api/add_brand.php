<?php

require '../../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

$brandName = $_POST['name'];

$db = new Database();
$loader = new DataLoader($db);

$stmt = $db->getPdo()->prepare("INSERT INTO brands (name) VALUES (?)");
$stmt->execute([$brandName]);

echo 'Brand added';
?>
<?php
