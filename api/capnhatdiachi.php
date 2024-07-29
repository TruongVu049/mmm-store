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
        'id' => $decode['id'],
        "sdt" => $decode['phone'],
        "diachi" => $decode['address'],
        "diachicuthe" => $decode['addressDetails'],
        "macdinh" => $decode['defaultAdd'],
    ];
    $capNhapDiaChi = $kh->capNhatDiaChi($data);
    if ($capNhapDiaChi) {
        echo json_encode($capNhapDiaChi);
    } else {
        echo json_encode(false);
    }
}
