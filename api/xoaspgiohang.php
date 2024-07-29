<?php
include_once "../classes/GioHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $gh = new GioHang();
    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);
    $xoaSp = $gh->xoaSanPham($decode["id"]);
    if ($xoaSp) {
        echo json_encode($xoaSp);
    } else {
        echo json_encode(false);
    }
}
