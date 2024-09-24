<?php

require '../../vendor/autoload.php'; // Veritabanı bağlantısı ve diğer işlemler için

use App\Database\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xmlUrl = $_POST['xmlUrl'];

    // XML'i oku
    $xmlContent = file_get_contents($xmlUrl);
    if ($xmlContent === false) {
        die('Could not read the XML file.');
    }

    // XML'i parse et
    $xml = simplexml_load_string($xmlContent);
    if ($xml === false) {
        die('Invalid XML format.');
    }

    $db = new Database();
    $pdo = $db->getPdo();

    try {
        $pdo->beginTransaction(); // İşlem başlat

        // Markaları ekle
        foreach ($xml->brand as $brand) {
            $brandId = (int) $brand->id;
            $brandName = (string) $brand->name;
            $brandUpdate = (string) $brand->update;

            // Marka ekle ya da güncelle
            $stmt = $pdo->prepare("INSERT INTO brands (id, name, update_date) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), update_date = VALUES(update_date)");
            $stmt->execute([$brandId, $brandName, $brandUpdate]);

            // Modelleri ekle
            if (isset($brand->models->model)) {
                foreach ($brand->models->model as $model) {
                    $modelId = (int) $model->id;
                    $modelName = (string) $model->name;
                    $modelUpdate = (string) $model->update;

                    // Modeli ekle ya da güncelle
                    $stmt = $pdo->prepare("INSERT INTO models (id, name, brand_id, update_date) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), update_date = VALUES(update_date)");
                    $stmt->execute([$modelId, $modelName, $brandId, $modelUpdate]);

                    // Modifikasyonları ekle
                    if (isset($model->generations->generation)) {
                        foreach ($model->generations->generation as $generation) {
                            if (isset($generation->modifications->modification)) {
                                foreach ($generation->modifications->modification as $modification) {
                                    $modId = (int) $modification->id;
                                    $engine = (string) $modification->engine;
                                    $yearStart = (int) $modification->yearstart;
                                    $yearStop = isset($modification->yearstop) ? (int) $modification->yearstop : null;
                                    $fuel = (string) $modification->fuel;
                                    $fuelSystem = isset($modification->fuelSystem) ? (string) $modification->fuelSystem : null;
                                    $engineOilCapacity = isset($modification->engineOilCapacity) ? (float) $modification->engineOilCapacity : null;
                                    $coolant = isset($modification->coolant) ? (float) $modification->coolant : null;
                                    $updateDate = (string) $modification->update;

                                    // Yakıt tipi ID'sini al
                                    $stmt = $pdo->prepare("SELECT id FROM fuel_types WHERE fuel = ?");
                                    $stmt->execute([$fuel]);
                                    $fuelTypeId = $stmt->fetchColumn();

                                    // Eğer yoksa, ekle
                                    if (!$fuelTypeId) {
                                        $stmt = $pdo->prepare("INSERT INTO fuel_types (fuel) VALUES (?)");
                                        $stmt->execute([$fuel]);
                                        $fuelTypeId = $pdo->lastInsertId();
                                    }

                                    // Yakıt sistemi ID'sini al
                                    $fuelSystemTypeId = null;
                                    if ($fuelSystem) {
                                        $stmt = $pdo->prepare("SELECT id FROM fuel_system_types WHERE fuel_system = ?");
                                        $stmt->execute([$fuelSystem]);
                                        $fuelSystemTypeId = $stmt->fetchColumn();

                                        // Eğer yoksa, ekle
                                        if (!$fuelSystemTypeId) {
                                            $stmt = $pdo->prepare("INSERT INTO fuel_system_types (fuel_system) VALUES (?)");
                                            $stmt->execute([$fuelSystem]);
                                            $fuelSystemTypeId = $pdo->lastInsertId();
                                        }
                                    }

                                    // Yağ tipleri ve onay kodlarını işle
                                    $oilTypeId = null;
                                    $oilApprovalId = null;

                                    if (isset($modification->engineOilSpecs->oil)) {
                                        $oilSpecs = (string) $modification->engineOilSpecs->oil;

                                        // Yağ tiplerini ve onay kodlarını ayrıştır
                                        $oilParts = explode('/', $oilSpecs);
                                        $oilTypes = explode(',', $oilParts[0]); // Yağ tipleri (örneğin 5W-30, 0W-30)
                                        $oilApprovals = isset($oilParts[1]) ? trim($oilParts[1]) : null; // Onay kodları (örneğin VW 507 00)

                                        // İlk yağ tipini al (örneğin 5W-30)
                                        $oilType = trim($oilTypes[0]);

                                        // Yağ tipi ID'sini al
                                        $stmt = $pdo->prepare("SELECT id FROM oil_types WHERE oil = ?");
                                        $stmt->execute([$oilType]);
                                        $oilTypeId = $stmt->fetchColumn();

                                        // Eğer yoksa, ekle ve ID'yi al
                                        if (!$oilTypeId) {
                                            $stmt = $pdo->prepare("INSERT INTO oil_types (oil) VALUES (?)");
                                            $stmt->execute([$oilType]);
                                            $oilTypeId = $pdo->lastInsertId();
                                        }

                                        // Onay kodunu al
                                        if ($oilApprovals) {
                                            $stmt = $pdo->prepare("SELECT id FROM oil_approvals WHERE approval = ?");
                                            $stmt->execute([$oilApprovals]);
                                            $oilApprovalId = $stmt->fetchColumn();

                                            // Eğer yoksa, ekle ve ID'yi al
                                            if (!$oilApprovalId) {
                                                $stmt = $pdo->prepare("INSERT INTO oil_approvals (approval) VALUES (?)");
                                                $stmt->execute([$oilApprovals]);
                                                $oilApprovalId = $pdo->lastInsertId();
                                            }
                                        }
                                    }

                                    // Modifikasyon ekle ya da güncelle ve yağ tipi ile onay kodu ID'lerini kaydet
                                    $stmt = $pdo->prepare("
                                        INSERT INTO modifications (id, engine, year_start, year_stop, engine_oil_capacity, coolant, update_date, model_id, fuel_type_id, fuel_system_type_id, oil_type_id, oil_approval_id) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ON DUPLICATE KEY UPDATE engine = VALUES(engine), year_start = VALUES(year_start), year_stop = VALUES(year_stop), engine_oil_capacity = VALUES(engine_oil_capacity), coolant = VALUES(coolant), update_date = VALUES(update_date), fuel_type_id = VALUES(fuel_type_id), fuel_system_type_id = VALUES(fuel_system_type_id), oil_type_id = VALUES(oil_type_id), oil_approval_id = VALUES(oil_approval_id)
                                    ");
                                    $stmt->execute([$modId, $engine, $yearStart, $yearStop, $engineOilCapacity, $coolant, $updateDate, $modelId, $fuelTypeId, $fuelSystemTypeId, $oilTypeId, $oilApprovalId]);

                                    // Modelin year_start ve year_stop alanlarını güncelle
                                    $stmt = $pdo->prepare("
                                        UPDATE models 
                                        SET year_start = LEAST(IFNULL(year_start, ?), ?),
                                            year_stop = GREATEST(IFNULL(year_stop, ?), ?)
                                        WHERE id = ?
                                    ");
                                    $stmt->execute([$yearStart, $yearStart, $yearStop, $yearStop, $modelId]);
                                }
                            }
                        }
                    }
                }
            }
        }

        $pdo->commit(); // İşlemi tamamla
        echo "XML data has been successfully imported.";
    } catch (Exception $e) {
        $pdo->rollBack(); // Hata olursa işlemi geri al
        die("Error processing XML: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
