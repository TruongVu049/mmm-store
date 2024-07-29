<?php
include_once "../classes/GioHang.php";
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET'  && isset($_GET['userid'])) {
    $gh = new GioHang();
    $laySl = $gh->laySlSpGioHang($_GET['userid']);
    if ($laySl) {
        echo json_encode($laySl);
    } else {
        echo json_encode(false);
    }
}
