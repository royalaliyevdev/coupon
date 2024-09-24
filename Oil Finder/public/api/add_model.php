<?php

require '../../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

// POST verilerini alın
$brandId = $_POST['brand_id'];
$modelName = $_POST['name'];
$yearStart = $_POST['year_start'];
$yearStop = $_POST['year_stop'];

$db = new Database();
$loader = new DataLoader($db);

// ID alanını eklemeyin, çünkü AUTO_INCREMENT devreye girecek
$stmt = $db->getPdo()->prepare("INSERT INTO models (name, brand_id, year_start, year_stop) VALUES (?, ?, ?, ?)");
$stmt->execute([$modelName, $brandId, $yearStart, $yearStop]);

echo 'Model added';
?>
