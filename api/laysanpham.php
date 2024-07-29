<?php
include_once "../classes/SanPham.php";
if (isset($_POST)) {
    $sp = new SanPham();
    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);

    $p = $decode["p"];
    $timKiem = $decode["s"];
    $limit = $decode["limit"];
    $pro = $decode['pro'];
    $t = $sp->laySLSanPhamKhKhuyenMai($timKiem, $pro);
    $tongTrang = (int)(ceil($t / $limit));
    $offset = ($p - 1) * $limit;
    $dsSP = $sp->laySanPhamKhuyenMai(offset: $offset, limit: $limit, timKiem: $timKiem, pro: $pro);
    if ($dsSP) {
        echo json_encode(["data" => $dsSP, "totalPage" => $tongTrang]);
    } else {
    }
}
