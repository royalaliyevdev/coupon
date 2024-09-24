<?php

namespace App\Database;

class DataLoader {
    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->getPdo();
    }

    public function loadBrands() {
        $stmt = $this->pdo->query("SELECT id, name FROM brands ORDER BY name");
        return $stmt->fetchAll();
    }

    public function loadModels($brandId) {
        $stmt = $this->pdo->prepare("SELECT id, name, year_start, year_stop FROM models WHERE brand_id = ? ORDER BY name");
        $stmt->execute([$brandId]);
        return $stmt->fetchAll();
    }

    public function loadEngines($modelId, $year) {
        $stmt = $this->pdo->prepare("SELECT id, engine FROM modifications WHERE model_id = ? AND ? BETWEEN year_start AND IFNULL(year_stop, ?)");
        $stmt->execute([$modelId, $year, $year]);
        return $stmt->fetchAll();
    }

    public function loadModelYears($modelId) {
        $stmt = $this->pdo->prepare("SELECT year_start, year_stop FROM models WHERE id = ?");
        $stmt->execute([$modelId]);
        return $stmt->fetch();
    }

    public function loadOilTypes($engineId) {
        // Yağ tipi, onay kodu, yağ kapasitesi ve soğutucu kapasitesi ile birlikte verileri çekiyoruz
        $stmt = $this->pdo->prepare("
            SELECT oil_types.oil, oil_approvals.approval, modifications.engine_oil_capacity, modifications.coolant
            FROM modifications 
            JOIN oil_types ON modifications.oil_type_id = oil_types.id 
            LEFT JOIN oil_approvals ON modifications.oil_approval_id = oil_approvals.id 
            WHERE modifications.id = ?
        ");
        $stmt->execute([$engineId]);
        return $stmt->fetchAll();
    }

    // Tüm yağ onaylarını ve eşdeğerlerini al
    public function loadAllOilApprovals() {
        $stmt = $this->pdo->query("
            SELECT o.id, o.approval, 
                GROUP_CONCAT(e.approval SEPARATOR ', ') AS equivalents,
                oe.can_replace
            FROM oil_approvals o
            LEFT JOIN oil_approval_equivalents oe ON o.id = oe.oil_approval_id
            LEFT JOIN oil_approvals e ON oe.equivalent_approval_id = e.id
            GROUP BY o.id
        ");
        return $stmt->fetchAll();
    }

    // Bir onayın eşdeğer onaylarını yükle
    public function loadOilApprovalEquivalents($approvalId) {
        $stmt = $this->pdo->prepare("
            SELECT e.approval, oe.can_replace
            FROM oil_approval_equivalents oe
            JOIN oil_approvals e ON oe.equivalent_approval_id = e.id
            WHERE oe.oil_approval_id = ?
        ");
        $stmt->execute([$approvalId]);
        return $stmt->fetchAll();
    }

    // Tüm onayları al (gerekli olmayanlar hariç)
    public function loadFilteredApprovals($excludeIds = []) {
        // Dışlanacak onayların listesi
        $excludeIdsString = implode(',', array_map('intval', $excludeIds));
        $query = "SELECT id, approval FROM oil_approvals";
        if (!empty($excludeIds)) {
            $query .= " WHERE id NOT IN ($excludeIdsString)";
        }
        $query .= " ORDER BY approval";

        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll();
    }
}
