<?php

require '../../vendor/autoload.php';
use App\Database\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $approvalId = $_POST['approval_id'];

    // Eğer equivalents bir string ise, bunu diziye çevir
    $equivalents = isset($_POST['equivalents']) ? $_POST['equivalents'] : [];

    if (is_string($equivalents)) {
        $equivalents = explode(',', $equivalents); // String'i diziye dönüştür
    }

    $canReplace = isset($_POST['can_replace']) ? 1 : 0;

    $db = new Database();
    $pdo = $db->getPdo();

    // Var olan eşdeğerleri temizle
    $stmt = $pdo->prepare("DELETE FROM oil_approval_equivalents WHERE oil_approval_id = ?");
    $stmt->execute([$approvalId]);

    // Yeni eşdeğerleri ekle
    $stmt = $pdo->prepare("INSERT INTO oil_approval_equivalents (oil_approval_id, equivalent_approval_id, can_replace) VALUES (?, ?, ?)");
    foreach ($equivalents as $equivalentId) {
        $stmt->execute([$approvalId, $equivalentId, $canReplace]);
    }

    echo 'Approval equivalents saved successfully';
}
?>
