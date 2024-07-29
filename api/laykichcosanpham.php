<?php
include_once "../classes/SanPham.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['sanphamid'], $_GET['loaisanphamid'])) {
    $sp = new SanPham();
    $kichcosanpham = $sp->layKichCoSanPhamId($_GET['sanphamid'], $_GET['loaisanphamid']);
    if ($kichcosanpham) {
        echo json_encode(["data" => $kichcosanpham]);
    } else {
    }
}
