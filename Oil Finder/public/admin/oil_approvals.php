<?php

require '../../vendor/autoload.php';
use App\Database\Database;
use App\Database\DataLoader;

$db = new Database();
$loader = new DataLoader($db);

// Tüm oil approvals (yağ onayları) ve eşdeğerlerini yükle
$oilApprovals = $loader->loadAllOilApprovals();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oil Approvals - Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Oil Approvals</h1>

    <!-- Dinamik olarak eklenen satırları göstermek için tablo -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Approval</th>
            <th>Equivalents</th>
            <th>Can Replace</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="approvalTableBody">
        <!-- Var olan onaylar için dinamik satırlar burada olacak -->
        </tbody>
    </table>

    <!-- + Butonu ile satır eklemek -->
    <div class="mt-4">
        <button id="addRowBtn" class="btn btn-success">+ Add New Row to Assign Equivalents</button>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="../js/bootstrap.bundle.min.js"></script>
<script>
    // Dinamik satır eklemek için JavaScript
    document.getElementById('addRowBtn').addEventListener('click', function() {
        // Yeni satırı dinamik olarak oluşturuyoruz
        const tableBody = document.getElementById('approvalTableBody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
        <td>
            <!-- Mevcut onayları göstermek için dropdown (select) -->
            <select class="form-select" name="approval_id">
                <option value="">Select Approval</option>
                <?php foreach ($oilApprovals as $approval): ?>
                    <option value="<?= $approval['id']; ?>"><?= htmlspecialchars($approval['approval']); ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <!-- Eşdeğer onayları seçmek için multiple select -->
            <select name="equivalents[]" class="form-select" multiple>
                <?php foreach ($oilApprovals as $newApproval): ?>
                    <option value="<?= $newApproval['id']; ?>"><?= htmlspecialchars($newApproval['approval']); ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <!-- Yerini alabilir checkbox -->
            <input type="checkbox" name="can_replace">
        </td>
        <td>
            <!-- Kaydet ve Sil butonları -->
            <button class="btn btn-primary saveBtn">Save</button>
            <button class="btn btn-danger removeBtn">Remove</button>
        </td>
    `;

        tableBody.appendChild(newRow);

        // Kaydet butonu
        const saveBtn = newRow.querySelector('.saveBtn');
        saveBtn.addEventListener('click', function() {
            // Kaydetme işlemi için veri gönderimi
            const approvalId = newRow.querySelector('select[name="approval_id"]').value;
            const equivalents = Array.from(newRow.querySelector('select[name="equivalents[]"]').selectedOptions).map(option => option.value);
            const canReplace = newRow.querySelector('input[name="can_replace"]').checked ? 1 : 0;

            // equivalents dizisini virgülle ayırıp string yapalım
            const equivalentsString = equivalents.join(',');

            // Ajax ile veriyi servera gönderme
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_approval.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Approval equivalents saved successfully!');
                } else {
                    alert('Error saving approval equivalents');
                }
            };
            xhr.send(`approval_id=${encodeURIComponent(approvalId)}&equivalents=${encodeURIComponent(equivalentsString)}&can_replace=${canReplace}`);
        });

        // Silme butonu
        const removeBtn = newRow.querySelector('.removeBtn');
        removeBtn.addEventListener('click', function() {
            tableBody.removeChild(newRow);
        });
    });
</script>
</body>
</html>
