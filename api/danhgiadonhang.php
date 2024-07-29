<?php
include_once "../classes/DonHang.php";
include_once "../classes/Session.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    try {
        Session::init();
        if (Session::get("cusId") == false || Session::get("cusEmail") == false) {
            throw new Exception();
        } else {
            $dh = new DonHang();
            $input = file_get_contents("php://input");
            $decode = json_decode($input, true);
            $data = [
                'arrId' => $decode['orderId'],
                "sosao" => $decode['star'],
                "binhluan" => $decode['mes'],
            ];
            $arrId = explode("_", $data['arrId']);
            $themDanhGia = $dh->danhGiaDonHang($arrId[0], Session::get("cusId"), $arrId[1], $data['sosao'], $data['binhluan']);
        }
        echo json_encode($themDanhGia);
    } catch (Exception $err) {
        echo json_encode(false);
    }
}
