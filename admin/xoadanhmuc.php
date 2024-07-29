<?php
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['id'])){
    require_once("../classes/Database.php");
    require_once("../classes/SanPham.php"); 
    $db = new Database();
    $sp = new SanPham();
    $id = $_GET["id"];
    $dsSp = $db->selectNonParam("select * from sanpham where DanhMuc_id = $id");
    foreach($dsSp as $item){
        $sp->xoaSanPham($item['id']);
    }
    $db->deleteNonParam("delete from danhmuc where id = $id");
    header('Location: danhmuc.php');
}

// sp id 62
// dh id 58


