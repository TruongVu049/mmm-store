<?php
include_once(__DIR__ . '/Database.php');
include_once(__DIR__ . '/../helpers/Fomat.php');

class DanhMuc
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function layDanhMuc()
    {
        return $this->db->selectNonParam("select * from danhmuc");
    }
}
