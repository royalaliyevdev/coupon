<?php

require '../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

if (isset($_GET['brand'])) {
    $brandId = $_GET['brand'];

    $db = new Database();
    $loader = new DataLoader($db);
    $models = $loader->loadModels($brandId);

    echo '<option value="">Select Model</option>';
    foreach ($models as $model) {
        echo '<option value="' . $model['id'] . '">' . $model['name'] . '</option>';
    }
} else {
    echo 'Brand ID not provided.';
}
?>
