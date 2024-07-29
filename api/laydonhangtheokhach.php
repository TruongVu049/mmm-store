<?php
include_once "../classes/DonHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['userid'], $_GET['type'])) {
    try {
        $dh = new DonHang();
        $dsdh = $dh->layDonHangTheoKhach($_GET['userid'], $_GET['type']);
        echo json_encode($dsdh);
    } catch (PDOException $err) {
        echo json_encode(false);
    }
}
