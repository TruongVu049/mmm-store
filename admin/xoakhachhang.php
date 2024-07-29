<?php
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['id'])){
    require_once("../classes/Database.php");
    try {
        $db = new Database();
        $id = $_GET["id"];
        $db->conn->beginTransaction();
        $dsdh = $db->selectNonParam("select * from donhang where KhachHang_id = $id");
        if (count($dsdh) != 0) {
            $dshd_id = array_map(
                fn ($d) => $d['id'],
                $dsdh
            );
            $db->deleteNonParam("delete from danhgiasanpham where KhachHang_id = $id");
            $db->deleteNonParam("delete from chitietdonhang where DonHang_id in (" . implode(',', $dshd_id) . ")");
        }
    
        
        $db->deleteNonParam("delete from donhang where KhachHang_id = $id");
        $db->deleteNonParam("delete from giohang where KhachHang_id = $id");
        $db->deleteNonParam("delete from diachi where KhachHang_id = $id");
        $db->deleteNonParam("delete from khachhang where id = $id");
        $db->conn->commit();
    } catch (PDOException $e) {
        $db->conn->rollBack();
    }
    header('Location: khachhang.php');
}
