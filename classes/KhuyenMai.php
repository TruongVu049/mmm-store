<?php
include_once(__DIR__ . '/Database.php');
include_once(__DIR__ . '/../helpers/Fomat.php');
class KhuyenMai
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function themKhuyenMai($data)
    {
        try {
            $this->db->conn->beginTransaction();

            $phantram = $this->fm->validation($data['phantram']);
            $thoigian_bd = $this->fm->validation($data['thoigian_bd']);
            $thoigian_kt = $this->fm->validation($data['thoigian_kt']);

            if ($thoigian_kt != "") {
                $query = "insert into khuyenmai(phantram, thoigian_bd, thoigian_kt)
                            values($phantram, '$thoigian_bd', '$thoigian_kt')
                        ";
            } else {
                $query = "insert into khuyenmai(phantram, thoigian_bd)
                            values($phantram, '$thoigian_bd')
                        ";
            }
            $khuyenmai_id = $this->db->insertNonParam($query);
            $this->db->updateNonParam("UPDATE khuyenmai
                SET ten ='Khuyến mãi $khuyenmai_id'
                WHERE id = $khuyenmai_id");

            $this->db->updateNonParam("UPDATE sanpham
                    SET KhuyenMai_id = $khuyenmai_id
                    WHERE id in (" . implode(',', $data['proId']) . ")");
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return false;
        }
    }
    public function layKhuyenMai($offset = 0, $limit = 0, $sapxep = "")
    {
        $query = "";
        if ($sapxep != "") {
            $arrSX = explode('_', $sapxep);
            if (strtolower($arrSX[1]) == "asc") {
                $query = "select khuyenmai.*, COUNT(sanpham.KhuyenMai_id) as sl
                from khuyenmai
                inner join sanpham on khuyenmai.id = sanpham.KhuyenMai_id
                GROUP by khuyenmai.id, khuyenmai.ten, khuyenmai.phantram, khuyenmai.thoigian_bd, khuyenmai.thoigian_kt
                ORDER BY " . $arrSX[0] . " " . $arrSX[1] .
                    " limit $offset,$limit ";
            } else if (strtolower($arrSX[1]) == "desc") {
                $query = "select khuyenmai.*, COUNT(sanpham.KhuyenMai_id) as sl
                from khuyenmai
                inner join sanpham on khuyenmai.id = sanpham.KhuyenMai_id
                GROUP by khuyenmai.id, khuyenmai.ten, khuyenmai.phantram, khuyenmai.thoigian_bd, khuyenmai.thoigian_kt
                ORDER BY " . $arrSX[0] . " " . $arrSX[1] .
                    " limit $offset,$limit ";
            } else if (strtolower($arrSX[1]) == "conhan") {
                $query = "select khuyenmai.*, COUNT(sanpham.KhuyenMai_id) as sl
                from khuyenmai
                inner join sanpham on khuyenmai.id = sanpham.KhuyenMai_id
                where khuyenmai.thoigian_kt >= CURDATE() or khuyenmai.thoigian_kt is null
                GROUP by khuyenmai.id, khuyenmai.ten, khuyenmai.phantram, khuyenmai.thoigian_bd, khuyenmai.thoigian_kt 
                 limit $offset,$limit ";
            } else {
                $query = "select khuyenmai.*, COUNT(sanpham.KhuyenMai_id) as sl
                from khuyenmai
                inner join sanpham on khuyenmai.id = sanpham.KhuyenMai_id
                where khuyenmai.thoigian_kt < CURDATE()
                GROUP by khuyenmai.id, khuyenmai.ten, khuyenmai.phantram, khuyenmai.thoigian_bd, khuyenmai.thoigian_kt 
                 limit $offset,$limit ";
            }
        } else {
            $query = "select khuyenmai.*, COUNT(sanpham.KhuyenMai_id) as sl
            from khuyenmai
            inner join sanpham on khuyenmai.id = sanpham.KhuyenMai_id
            GROUP by khuyenmai.id, khuyenmai.ten, khuyenmai.phantram, khuyenmai.thoigian_bd, khuyenmai.thoigian_kt
             limit $offset,$limit ";
        }
        // return $query;
        return $this->db->selectNonParam($query);
    }
    public function laySLKhuyenMai()
    {
        $sl = $this->db->selectNonParam("select COUNT(*) as sl from khuyenmai");
        return $sl[0]["sl"];
    }
    public function layKhuyenMaiId($id)
    {
        $km = $this->db->selectNonParam("select * from khuyenmai where id = $id")[0];
        $spkm = $this->db->selectNonParam("select sanpham.*,  MIN(loaisanpham.hinhanh) as hinhanh
        from loaisanpham 
        left join sanpham on sanpham.id = loaisanpham.SanPham_id 
        where KhuyenMai_id = " . $km['id'] . "
         group by sanpham.id  ");
        $km['sanpham'] = $spkm;
        return $km;
    }

    public function suaKhuyenMai($data)
    {
        try {
            $this->db->conn->beginTransaction();
            if (array_key_exists('them_thoigian_kt', $data)) {
                $query = "UPDATE khuyenmai 
                SET phantram = " . $data['phantram'] . ", thoigian_kt = '" . $data['thoigian_kt'] . "' 
                WHERE id = " . $data['id'];
            } else {
                $query = "UPDATE khuyenmai 
                SET phantram = " . $data['phantram'] . ", thoigian_kt = null
                WHERE id = " . $data['id'];
            }
            $this->db->updateNonParam($query);
            $this->db->updateNonParam("UPDATE sanpham 
                SET KhuyenMai_id = null
                WHERE KhuyenMai_id = " . $data['id']);
            $this->db->updateNonParam("UPDATE sanpham 
            SET KhuyenMai_id = " . $data['id'] . "
            WHERE id in (" . implode(',', $data['proId']) . ")");

            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return false;
        }
    }
    public function xoaKhuyenMai($id)
    {
        try {
            $this->db->conn->beginTransaction();
            $sp = $this->layKhuyenMaiId($id);
            $sp = array_map(function ($item) {
                return $item['id'];
            }, $sp['sanpham']);
            $this->db->updateNonParam("UPDATE sanpham 
            SET KhuyenMai_id = null
            WHERE KhuyenMai_id = $id");
            $this->db->deleteNonParam("DELETE FROM khuyenmai
            WHERE id = $id");

            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return false;
        }
    }
}
