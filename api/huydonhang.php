<?php
include_once "../classes/DonHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    try {
        $dh = new DonHang();
        $input = file_get_contents("php://input");
        $decode = json_decode($input, true);
        $huyDonHang = $dh->huyDonHang($decode["dhId"], $decode["loaiId"]);
        if ($huyDonHang) {
            echo json_encode($huyDonHang);
        } else {
            echo json_encode(false);
        }
    } catch (Exception $err) {
        echo json_encode(false);
    }
}
