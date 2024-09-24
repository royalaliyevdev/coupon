<?php

require '../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

$modelId = $_GET['model'];
$year = $_GET['year'];

$db = new Database();
$loader = new DataLoader($db);
$engines = $loader->loadEngines($modelId, $year);

echo '<option value="">Select Engine</option>';
foreach ($engines as $engine) {
    echo '<option value="' . $engine['id'] . '">' . $engine['engine'] . '</option>';
}
?>
