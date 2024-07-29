<?php
include_once "../classes/SanPham.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['spId'], $_GET['p'])) {
    try {
        $sp = new SanPham();
        $limit = 3;
        $dsbl = $sp->layDsBinhLuan($_GET['spId']);
        $tongTrang = ceil(floatval(count($dsbl)) / floatval($limit));
        $offset = (intval($_GET['p']) - 1) * $limit;
        $dsbl = array_slice($dsbl, $offset, $limit);
        echo json_encode([
            'dsbl' => $dsbl,
            'tongtrang' => $tongTrang
        ]);
    } catch (PDOException $err) {
        echo json_encode(false);
    }
}
