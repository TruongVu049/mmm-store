<?php
include_once "../classes/GioHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    $gh = new GioHang();
    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);
    // userId:
    // "18"
    // sizeId:
    // "7"
    // quantity:
    // "1"
    $themGH = $gh->them($decode["userId"], $decode["sizeId"], $decode["quantity"]);
    if ($themGH) {
        echo json_encode(["data" => $themGH]);
    } else {
        echo json_encode(["data" => false]);
    }
}
