<?php

require '../vendor/autoload.php';

use App\Database\Database;
use App\Database\DataLoader;

$modelId = $_GET['model'];

$db = new Database();
$loader = new DataLoader($db);
$modelYears = $loader->loadModelYears($modelId);

if ($modelYears) {
    $yearStart = $modelYears['year_start'];
    $yearStop = $modelYears['year_stop'];

    // Eğer year_stop null ise, current year (mevcut yıl) al
    if (is_null($yearStop)) {
        $yearStop = date('Y');
    }

    echo '<option value="">Select Year</option>';
    for ($year = $yearStart; $year <= $yearStop; $year++) {
        echo '<option value="' . $year . '">' . $year . '</option>';
    }
} else {
    echo '<option value="">No years available</option>';
}
?>
