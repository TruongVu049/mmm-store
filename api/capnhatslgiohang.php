<?php
include_once "../classes/GioHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $gh = new GioHang();
    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);
    $capNhatSl = $gh->capNhatSoLuong($decode['id'], $decode['type'], $decode['qt']);
    if ($capNhatSl) {
        echo json_encode($capNhatSl);
    } else {
        echo json_encode(false);
    }
}
