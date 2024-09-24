<?php

require '../../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

$modelId = $_POST['model_id'];
$engine = $_POST['engine'];
$oilCapacity = $_POST['oil_capacity'];

$db = new Database();
$loader = new DataLoader($db);

$stmt = $db->getPdo()->prepare("INSERT INTO modifications (model_id, engine, engine_oil_capacity) VALUES (?, ?, ?)");
$stmt->execute([$modelId, $engine, $oilCapacity]);

echo 'Engine added';
?>
