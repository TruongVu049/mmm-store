<?php
include_once "../classes/GioHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['userid'])) {
    try {
        $gh = new GioHang();
        if (isset($_GET['sort']) && $_GET['sort'] === "desc") {
            $sp = $gh->laySpGioHang($_GET['userid'], "ORDER BY giohang.ngaythem DESC", $_GET['limit']);
        } else {
            $sp = $gh->laySpGioHang($_GET['userid'], "ORDER BY giohang.ngaythem DESC", $_GET['limit']);
        }
        echo json_encode($sp);
    } catch (PDOException $err) {
        echo json_encode(false);
    }
}
