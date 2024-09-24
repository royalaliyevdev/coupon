<?php
include '../resources/views/admin/header.php';
$sql_active = "SELECT COUNT(*) AS active_count FROM coupons WHERE status = 'active'";
$result_active = $conn->query($sql_active);
$row_active = $result_active->fetch_assoc();
$active_count = $row_active['active_count'];

$sql_used = "SELECT COUNT(*) AS used_count FROM coupons WHERE used = 'yes'";
$result_used = $conn->query($sql_used);
$row_used = $result_used->fetch_assoc();
$used_count = $row_used['used_count'];

$sql_total = "SELECT COUNT(*) AS total_count FROM coupons";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_count = $row_total['total_count'];

$conn->close();
?>
<body>
<div class="container mt-5">
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Aktivleşdirilmiş Kupon</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $active_count; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">İstifadə olunmuş Kupon</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $used_count; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Toplam Kupon Sayı</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $total_count; ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../resources/views/admin/footer.php'; ?>
