<?php

require '../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

$db = new Database();
$loader = new DataLoader($db);
$brands = $loader->loadBrands();

echo '<option value="">Select Brand</option>';
foreach ($brands as $brand) {
    echo '<option value="' . $brand['id'] . '">' . $brand['name'] . '</option>';
}
?>
