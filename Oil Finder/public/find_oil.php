<?php

require '../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

$engineId = $_GET['engine'];

$db = new Database();
$loader = new DataLoader($db);
$oilTypes = $loader->loadOilTypes($engineId);

if ($oilTypes) {
    foreach ($oilTypes as $oil) {
        echo '<p>' . $oil['oil'] . '</p>';

        // Eğer approval varsa, yağ tipinin altında göster
        if (!empty($oil['approval'])) {
            echo '<p>' . $oil['approval'] . '</p>';
        }

        // Motor yağ kapasitesini göster
        if (!empty($oil['engine_oil_capacity'])) {
            echo '<p>' . $oil['engine_oil_capacity'] . ' liters</p>';
        }

        // Soğutucu kapasitesini göster
        if (!empty($oil['coolant'])) {
            echo '<p>' . $oil['coolant'] . ' liters</p>';
        }
    }
} else {
    echo '<p>No oil types found for this engine.</p>';
}
?>
