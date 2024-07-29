<?php
include_once "../classes/KhachHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['userid'])) {
    try {
        $kh = new KhachHang();
        $layDc = $kh->layDiaChi($_GET['userid']);
        echo json_encode($layDc);
    } catch (PDOException $err) {
        echo json_encode(false);
    }
}
