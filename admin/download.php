<?php
require '../config.php';
require '../vendor/autoload.php';  // Including Composer's autoload file

use setasign\Fpdi\Fpdi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_ids'])) {
    $coupon_ids = $_POST['coupon_ids'];

    $pdf = new Fpdi();
    $coupon_per_page = 3; // Kupon başına sayfa sayısı
    $current_coupon = 0;

    foreach ($coupon_ids as $coupon_id) {
        $pdf_path = "../generated_coupons/coupon_$coupon_id.pdf";
        if (file_exists($pdf_path)) {
            if ($current_coupon % $coupon_per_page === 0) {
                $pdf->AddPage('P', 'A4');
            }
            $page_count = $pdf->setSourceFile($pdf_path);
            $tplIdx = $pdf->importPage(1);

            $x = 0;
            $y = 0 + ($current_coupon % $coupon_per_page) * 99; // Y konumunu her kupon için ayarlama

            $pdf->useTemplate($tplIdx, $x, $y, 210, 297); // Kuponları yerleştirme

            $current_coupon++;
        }
    }

    $pdf_output_path = '../generated_coupons/selected_coupons.pdf';
    $pdf->Output($pdf_output_path, 'F');

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="selected_coupons.pdf"');
    readfile($pdf_output_path);
    exit;
}

$conn->close();
header("Location: list.php");
exit;
?>
