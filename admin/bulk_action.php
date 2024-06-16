<?php
require '../config.php';
require '../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $coupon_numbers = isset($_POST['coupon_numbers']) ? $_POST['coupon_numbers'] : [];

    if ($action === 'delete' && !empty($coupon_numbers)) {
        $coupon_numbers_str = implode(",", array_map('intval', $coupon_numbers));
        $sql = "DELETE FROM coupons WHERE coupon_number IN ($coupon_numbers_str)";
        if ($conn->query($sql) === TRUE) {
            echo "Coupons deleted successfully";
        } else {
            echo "Error deleting coupons: " . $conn->error;
        }
    } elseif ($action === 'download' && !empty($coupon_numbers)) {
        $pdf = new Fpdi();
        $coupons_per_page = 3;
        $coupon_count = 0;

        foreach ($coupon_numbers as $coupon_number) {
            $file_path = "../generated_coupons/coupon_$coupon_number.pdf";
            if (file_exists($file_path)) {
                if ($coupon_count % $coupons_per_page === 0) {
                    $pdf->AddPage();
                    $x = 0;
                    $y = 0;
                }

                $page_count = $pdf->setSourceFile($file_path);
                for ($page_no = 1; $page_no <= $page_count; $page_no++) {
                    $tplIdx = $pdf->importPage($page_no);
                    $pdf->useTemplate($tplIdx, $x, $y, 210);
                    $y += 99; // Adjust the y position for the next coupon
                }

                $coupon_count++;
            } else {
                echo "File not found: $file_path";
            }
        }

        $pdf->Output('D', 'coupons.pdf');
        exit;
    }
    header("Location: list.php");
    exit;
}
?>
