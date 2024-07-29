<?php
include_once "../classes/DonHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['id'])) {
    try {
        $dh = new DonHang();
        $dsdh = $dh->layChiTietDonHang($_GET['id']);
        echo json_encode($dsdh);
    } catch (PDOException $err) {
        echo json_encode(false);
    }
}
