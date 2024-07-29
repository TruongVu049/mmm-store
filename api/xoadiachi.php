<?php
include_once "../classes/KhachHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $kh = new KhachHang();
    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);
    // id:
    // "18"
    $xoaDiaChi = $kh->xoaDiaChi($decode["id"]);
    if ($xoaDiaChi) {
        echo json_encode($xoaDiaChi);
    } else {
        echo json_encode(false);
    }
}
