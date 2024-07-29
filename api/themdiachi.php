<?php
include_once "../classes/KhachHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $kh = new KhachHang();
    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);
    // phone:
    // "0384812080"
    // address:
    // "Thành phố Hồ Chí Minh, Quận 1, Phường Tân Định"
    // addressDetails:
    // "dia chi cu the"
    // defaultAdd:
    // 1    diachi.sdt, diachi.diachi, diachi.diachicuthe, diachi.KhachHang_id
    $data = [
        "sdt" => $decode['phone'],
        "diachi" => $decode['address'],
        "diachicuthe" => $decode['addressDetails'],
        "macdinh" => $decode['defaultAdd'],
        "KhachHang_id" => $decode['userId']
    ];
    $themDiaChi = $kh->themDiaChi($data);
    if ($themDiaChi) {
        echo json_encode($themDiaChi);
    } else {
        echo json_encode(false);
    }
}
