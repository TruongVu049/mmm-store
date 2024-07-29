<?php
include_once(__DIR__ . '/Database.php');
class DonHang
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /*
   Array
    (
        [userId] => 18
        [addressId] => 11
        [sp] => Array
            (
                [0] => 26_1
                [1] => 45_1
                [2] => 56_1
            )
    )
    */
    public function themDonHang($data)
    {
        try {
            if (count($data['sp']) <= 0) {
                throw new Exception("err");
            }
            $tongTien = 0;
            $queryCtdh = "insert into chitietdonhang(chitietdonhang.SanPham_id, chitietdonhang.DonHang_id, chitietdonhang.gia, chitietdonhang.soluong) values";
            $queryU = "
            update kichcosanpham INNER JOIN chitietdonhang ON kichcosanpham.id = chitietdonhang.SanPham_id
            set kichcosanpham.soluong = kichcosanpham.soluong - chitietdonhang.soluong
            where kichcosanpham.id in (";
            foreach ($data['sp'] as $item) {
                $dh = explode('_', $item);
                $queryU .= $dh[0] . ",";
                $sp = $this->db->selectNonParam("select sanpham.KhuyenMai_id, sanpham.gia, khuyenmai.phantram, khuyenmai.thoigian_bd, khuyenmai.thoigian_kt
                from kichcosanpham
                INNER join sanpham on sanpham.id = kichcosanpham.SanPham_id
                left join khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                where kichcosanpham.id = " . $dh[0]);
                $giaTien = 0;
                if (is_null($sp[0]['KhuyenMai_id'])) {
                    $giaTien = floatval($sp[0]['gia']);
                } else {
                    if (is_null($sp[0]['thoigian_kt'])) {
                        $giaTien = floatval($sp[0]['gia']) - (floatval($sp[0]['gia']) * (floatval($sp[0]['phantram']) / 100));
                    } else {
                        if (strtotime($sp[0]['thoigian_kt']) > strtotime(date('Y-m-d'))) {
                            $giaTien = floatval($sp[0]['gia']) - (floatval($sp[0]['gia']) * (floatval($sp[0]['phantram']) / 100));
                        } else {
                            $giaTien = floatval($sp[0]['gia']);
                        }
                    }
                }
                $tongTien += ($giaTien * intval($dh[1]));
                $queryCtdh .= "(" . $dh[0] . ", donhang_idN, " . $giaTien . ", " . $dh[1] . "),";
            }
            $queryCtdh = substr($queryCtdh, 0, strlen($queryCtdh) - 1);
            $queryU = substr($queryU, 0, strlen($queryU) - 1);
            $diaChi = $this->db->selectNonParam("select * from diachi where diachi.id = " . $data['addressId'] . " and diachi.KhachHang_id = " . $data['userId']);
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $queryHd = "insert into donhang(donhang.tongtien, donhang.ngaytao, donhang.KhachHang_id, donhang.TrangThaiDonHang_id, donhang.diachi) 
            values(" . $tongTien . ", '" . date('Y-m-d H:i:s') . "', " . $data['userId'] . ", 1, '" . $diaChi[0]['sdt'] . ", " . $diaChi[0]['diachicuthe'] . ", " . $diaChi[0]['diachi'] . "')";

            $this->db->conn->beginTransaction();
            $dhId = $this->db->insertNonParam($queryHd);
            $queryCtdh = str_replace('donhang_idN', $dhId, $queryCtdh);
            $themCtdh = $this->db->insertNonParam($queryCtdh);
            $capNhatSoLuong = $this->db->updateNonParam($queryU . ");");
            $this->db->conn->commit();
            return $dhId;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
    }
    public function layDonHang($loaiId, $p = 1, $sx, $tk)
    {
        try {
            $limit = 8;
            if ($sx !== "") {
                $arrSx = explode("_", $sx);
            }
            $dsdh = $this->db->selectNonParam(
                "select donhang.*, khachhang.ten, trangthaidonhang.trangthai FROM donhang inner join khachhang on khachhang.id = donhang.KhachHang_id 
                INNER join trangthaidonhang on trangthaidonhang.id = donhang.TrangThaiDonHang_id where donhang.TrangThaiDonHang_id = $loaiId
            " . ($tk !== "" ? "and donhang.id = $tk" : "") . "  " . (isset($arrSx) ? "order by donhang." . $arrSx[0] . " " . $arrSx[1] : "ORDER BY donhang.ngaytao DESC, donhang.ngaysua DESC")
            );

            $tongTrang = ceil(floatval(count($dsdh)) / floatval($limit));
            $offset = (intval($p) - 1) * $limit;
            $dsdh = array_slice($dsdh, $offset, $limit);
            return [
                'dshd' => $dsdh,
                'tongtrang' => $tongTrang
            ];
        } catch (Exception $err) {
            return [];
        }
    }
    public function layDonHangTheoKhach($khId, $loaiId)
    {
        try {
            $query = "select donhang.id, donhang.TrangThaiDonHang_id, donhang.tongtien, donhang.ngaytao, donhang.ngaysua, donhang.diachi, trangthaidonhang.trangthai, 
            chitietdonhang.gia, chitietdonhang.soluong, sanpham.id as SanPham_id, kichcosanpham.id as KichCoSanPham_id, 
            sanpham.ten, loaisanpham.mausac, loaisanpham.hinhanh, kichcosanpham.kichco, danhgiasanpham.DonHang_id as danhgiasanpham_id
            from donhang
            INNER JOIN trangthaidonhang on trangthaidonhang.id = donhang.TrangThaiDonHang_id
            INNER join chitietdonhang on donhang.id = chitietdonhang.DonHang_id
            INNER JOIN kichcosanpham on kichcosanpham.id = chitietdonhang.SanPham_id
            inner join loaisanpham on loaisanpham.id = kichcosanpham.LoaiSanPham_id and loaisanpham.SanPham_id = kichcosanpham.SanPham_id
            inner join sanpham on sanpham.id = loaisanpham.SanPham_id
            left join danhgiasanpham on danhgiasanpham.DonHang_id = chitietdonhang.DonHang_id and danhgiasanpham.SanPham_id = chitietdonhang.SanPham_id
            where donhang.KhachHang_id = $khId and donhang.TrangThaiDonHang_id = $loaiId
            order by donhang.ngaytao desc";
            $dsdh = $this->db->selectNonParam($query);
            return $dsdh;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function layChiTietDonHang($dhId)
    {
        try {
            $query = "
            select donhang.id, donhang.tongtien, donhang.ngaytao, donhang.ngaysua, donhang.diachi, trangthaidonhang.trangthai, 
            chitietdonhang.gia, chitietdonhang.soluong, sanpham.id as SanPham_id, kichcosanpham.id as KichCoSanPham_id, 
            sanpham.ten, loaisanpham.mausac, loaisanpham.hinhanh, kichcosanpham.kichco
            from donhang
            INNER JOIN trangthaidonhang on trangthaidonhang.id = donhang.TrangThaiDonHang_id
            INNER join chitietdonhang on donhang.id = chitietdonhang.DonHang_id
            INNER JOIN kichcosanpham on kichcosanpham.id = chitietdonhang.SanPham_id
            inner join loaisanpham on loaisanpham.id = kichcosanpham.LoaiSanPham_id and loaisanpham.SanPham_id = kichcosanpham.SanPham_id
            inner join sanpham on sanpham.id = loaisanpham.SanPham_id
            where donhang.id = $dhId
            ";
            $dsdh = $this->db->selectNonParam($query);
            return $dsdh;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function xuLyDonHang($dhId, $loaiId)
    {
        try {
            $capNhatDonHang = $this->db->updateNonParam("update donhang set donhang.TrangThaiDonHang_id = $loaiId, donhang.ngaysua = now() where donhang.id = $dhId");
            return $capNhatDonHang;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function huyDonHang($dhId, $loaiId)
    {
        try {
            $this->db->conn->beginTransaction();
            $dsCtdh = $this->db->selectNonParam("select chitietdonhang.SanPham_id from chitietdonhang where DonHang_id = $dhId");
            $dsCtdh = array_map(function ($item) {
                return $item['SanPham_id'];
            }, $dsCtdh);
            $queryU = "
            update kichcosanpham INNER JOIN chitietdonhang ON kichcosanpham.id = chitietdonhang.SanPham_id
            set kichcosanpham.soluong = kichcosanpham.soluong + chitietdonhang.soluong
            where kichcosanpham.id in (" . implode(',', $dsCtdh) . ");";

            $this->db->updateNonParam("update donhang 
            set TrangThaiDonHang_id = 4, ngaysua = now()
            where id = $dhId");
            $this->db->updateNonParam($queryU);
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
    }

    public function danhGiaDonHang($dhId, $khId, $spId, $soSao, $noiDung)
    {
        try {
            $this->db->conn->beginTransaction();
            $this->db->selectNonParam("
            INSERT into danhgiasanpham(danhgiasanpham.KhachHang_id, danhgiasanpham.DonHang_id, danhgiasanpham.SanPham_id, danhgiasanpham.sosao,danhgiasanpham.binhluan, ngaytao)
            values($khId, $dhId, $spId, $soSao, '$noiDung', now());
            ");
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
    }
}
