<?php

use function PHPSTORM_META\map;

include_once(__DIR__ . '/Database.php');
include_once(__DIR__ . '/../helpers/Fomat.php');
class SanPham
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function themSanPham($data)
    {
        try {
            $this->db->conn->beginTransaction();

            $ten = $this->fm->validation($data['ten']);
            $mota = $this->fm->validation($data['mota']);
            $gia = $this->fm->validation($data['gia']);
            $gioitinh = $this->fm->validation($data['gioitinh']);
            $anhdaidien = $this->fm->validation($data['image1']);
            $DanhMuc_id = $this->fm->validation($data['DanhMuc_id']);
            $msg = "";
            $loaiSanPham = json_decode(stripslashes($data['data']), true);

            $query = "insert into sanpham(ten, mota, gia, gioitinh, DanhMuc_id, anhdaidien)
            values('$ten', '$mota', $gia, '$gioitinh', $DanhMuc_id, '$anhdaidien')
        ";
            $sanpham_id = $this->db->insertNonParam($query);
            if ($sanpham_id) {
                foreach ($loaiSanPham as $lsp) {
                    $query = "insert into loaisanpham(mausac, hinhanh, SanPham_id)
                    values('" . $lsp["color"] . "', '" . $lsp["image"] . "', " . $sanpham_id . ")
                ";
                    $loaiSanPham_id = $this->db->insertNonParam($query);
                    foreach ($lsp["option_value"] as $kcsp) {
                        $query_kcsp = "insert into kichcosanpham(kichco, soluong, SanPham_id, LoaiSanPham_id)
                        values('" . $kcsp["size"] . "', " . $kcsp["quantity"] . ", " . $sanpham_id . ", " . $loaiSanPham_id . ")
                    ";
                        $kichCoSanPham_id = $this->db->insertNonParam($query_kcsp);
                    }
                }
            } else {
                $msg = "<span class='error'>Đã có lỗi xảy ra</span>";
            }
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return false;
        }
    }

    public function laySanPham($offset = 0, $limit = 0, $timKiem = "", $sapxep = "", $gia_nn = null, $gia_ln = null, $ft_danhmuc = null, $ft_gioitinh = null)
    {
        $query = "";
        $queryCount = "";
        $arrSX = explode('_', $sapxep);
        $timKiem = trim($timKiem);

        $locTuyChon = "";
        if (!is_null($gia_ln) && !is_null($gia_nn)) {
            $locTuyChon = $locTuyChon . " gia BETWEEN $gia_nn AND $gia_ln ";
            if (!is_null($ft_danhmuc) && count($ft_danhmuc) != 0) {
                $locTuyChon = $locTuyChon . " and DanhMuc_id IN (" . implode(',', $ft_danhmuc) . ") ";
            }
            if (!is_null($ft_gioitinh) && count($ft_gioitinh) != 0) {
                $ft_gioitinh = array_map(function ($item) {
                    return "'" . $item . "'";
                }, $ft_gioitinh);
                $locTuyChon = $locTuyChon . " and gioitinh IN (" . implode(",", $ft_gioitinh) . ") ";
            }
        }

        if ($timKiem == "") {
            if ($sapxep == "") {
                $locTuyChon =  $locTuyChon != "" ? "where $locTuyChon" : " ";
                $query = "
                select sanpham.id, sanpham.ten, sanpham.gia, sanpham.gioitinh, sanpham.ngaytao, sanpham.DanhMuc_id, sanpham.KhuyenMai_id, sanpham.anhdaidien as hinhanh, khuyenmai.thoigian_kt, khuyenmai.phantram, donhang.sosaotb, donhang.luotban
                from sanpham
                left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                INNER join (
                  select kichcosanpham.SanPham_id, avg(sosaotb) as sosaotb, sum(luotban) as luotban 
                    from kichcosanpham
                    LEFT join (
                        select chitietdonhang.SanPham_id, avg(danhgiasanpham.sosao) as sosaotb, count(chitietdonhang.SanPham_id) as luotban
                        from chitietdonhang
                        INNER join donhang on donhang.id = chitietdonhang.DonHang_id
                        left join danhgiasanpham on danhgiasanpham.SanPham_id = chitietdonhang.SanPham_id and danhgiasanpham.DonHang_id = chitietdonhang.DonHang_id
                        where donhang.TrangThaiDonHang_id = 3
                        group by chitietdonhang.SanPham_id    
                    ) as donhang on donhang.SanPham_id = kichcosanpham.id
                    group by kichcosanpham.SanPham_id  
                 ) as donhang on donhang.SanPham_id = sanpham.id
                $locTuyChon
                LIMIT $offset,$limit
                ";
            } else {
                $locTuyChon = $locTuyChon != "" ? "where $locTuyChon" : " ";
                $query = "
                select sanpham.id, sanpham.ten, sanpham.gia, sanpham.gioitinh, sanpham.ngaytao, sanpham.DanhMuc_id, sanpham.KhuyenMai_id, sanpham.anhdaidien as hinhanh, khuyenmai.thoigian_kt, khuyenmai.phantram, donhang.sosaotb, donhang.luotban
                from sanpham
                left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                INNER join (
                  select kichcosanpham.SanPham_id, avg(sosaotb) as sosaotb, sum(luotban) as luotban 
                    from kichcosanpham
                    LEFT join (
                        select chitietdonhang.SanPham_id, avg(danhgiasanpham.sosao) as sosaotb, count(chitietdonhang.SanPham_id) as luotban
                        from chitietdonhang
                        INNER join donhang on donhang.id = chitietdonhang.DonHang_id
                        left join danhgiasanpham on danhgiasanpham.SanPham_id = chitietdonhang.SanPham_id and danhgiasanpham.DonHang_id = chitietdonhang.DonHang_id
                        where donhang.TrangThaiDonHang_id = 3
                        group by chitietdonhang.SanPham_id    
                    ) as donhang on donhang.SanPham_id = kichcosanpham.id
                    group by kichcosanpham.SanPham_id  
                 ) as donhang on donhang.SanPham_id = sanpham.id
                $locTuyChon
                ORDER BY " . $arrSX[0] . " " . $arrSX[1] .
                    " LIMIT $offset,$limit
                ";
            }
            $queryCount = "select COUNT(*) as sl from sanpham $locTuyChon";
        } else {
            if ($sapxep == "") {
                $locTuyChon = $locTuyChon != "" ? " and $locTuyChon" : " ";
                $query = "
                
                select sanpham.id, sanpham.ten, sanpham.gia, sanpham.gioitinh, sanpham.ngaytao, sanpham.DanhMuc_id, sanpham.KhuyenMai_id, sanpham.anhdaidien as hinhanh, khuyenmai.thoigian_kt, khuyenmai.phantram, donhang.sosaotb, donhang.luotban
                from sanpham
                left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                INNER join (
                  select kichcosanpham.SanPham_id, avg(sosaotb) as sosaotb, sum(luotban) as luotban 
                    from kichcosanpham
                    LEFT join (
                        select chitietdonhang.SanPham_id, avg(danhgiasanpham.sosao) as sosaotb, count(chitietdonhang.SanPham_id) as luotban
                        from chitietdonhang
                        INNER join donhang on donhang.id = chitietdonhang.DonHang_id
                        left join danhgiasanpham on danhgiasanpham.SanPham_id = chitietdonhang.SanPham_id and danhgiasanpham.DonHang_id = chitietdonhang.DonHang_id
                        where donhang.TrangThaiDonHang_id = 3
                        group by chitietdonhang.SanPham_id    
                    ) as donhang on donhang.SanPham_id = kichcosanpham.id
                    group by kichcosanpham.SanPham_id  
                 ) as donhang on donhang.SanPham_id = sanpham.id
                where sanpham.ten LIKE '%$timKiem%' $locTuyChon 
                LIMIT $offset,$limit
                ";
            } else {
                $locTuyChon = $locTuyChon != "" ? " and $locTuyChon" : " ";
                $query = "
                select sanpham.id, sanpham.ten, sanpham.gia, sanpham.gioitinh, sanpham.ngaytao, sanpham.DanhMuc_id, sanpham.KhuyenMai_id, sanpham.anhdaidien as hinhanh, khuyenmai.thoigian_kt, khuyenmai.phantram, donhang.sosaotb, donhang.luotban
                from sanpham
                left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                INNER join (
                  select kichcosanpham.SanPham_id, avg(sosaotb) as sosaotb, sum(luotban) as luotban 
                    from kichcosanpham
                    LEFT join (
                        select chitietdonhang.SanPham_id, avg(danhgiasanpham.sosao) as sosaotb, count(chitietdonhang.SanPham_id) as luotban
                        from chitietdonhang
                        INNER join donhang on donhang.id = chitietdonhang.DonHang_id
                        left join danhgiasanpham on danhgiasanpham.SanPham_id = chitietdonhang.SanPham_id and danhgiasanpham.DonHang_id = chitietdonhang.DonHang_id
                        where donhang.TrangThaiDonHang_id = 3
                        group by chitietdonhang.SanPham_id    
                    ) as donhang on donhang.SanPham_id = kichcosanpham.id
                    group by kichcosanpham.SanPham_id  
                 ) as donhang on donhang.SanPham_id = sanpham.id
                where sanpham.ten LIKE '%$timKiem%' $locTuyChon 
                ORDER BY " . $arrSX[0] . " " . $arrSX[1] .
                    " LIMIT $offset,$limit
                ";
            }
            $queryCount = "select COUNT(*) as sl from sanpham where sanpham.ten LIKE '%$timKiem%' $locTuyChon ";
        }
        // return $query;
        $sp = $this->db->selectNonParam($query);
        $sl = $this->db->selectNonParam($queryCount);
        return [
            "sp" => $sp,
            "sl" => $sl[0]["sl"]
        ];
    }
    public function laySanPhamKhuyenMai($offset = 0, $limit = 0, $timKiem = "", $pro)
    {
        $query = "";
        $timKiem = trim($timKiem);
        if (count($pro) != 0) {
            $queryIn = "sanpham.id in (" . implode(',', $pro) . ") or (sanpham.KhuyenMai_id is null or (khuyenmai.thoigian_kt is not null and CURDATE() > khuyenmai.thoigian_kt ))";
        } else {
            $queryIn = "sanpham.KhuyenMai_id is null or (khuyenmai.thoigian_kt is not null and CURDATE() > khuyenmai.thoigian_kt )";
        }
        if ($timKiem == "") {
            $query = "select sanpham.id, sanpham.ten, sanpham.gia, sanpham.gioitinh, sanpham.ngaytao, sanpham.DanhMuc_id, sanpham.KhuyenMai_id, sanpham.anhdaidien as hinhanh,  khuyenmai.thoigian_kt
                from  sanpham
                left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                where $queryIn
                LIMIT $offset,$limit
                ";
        } else {
            $query = "
                select sanpham.id, sanpham.ten, sanpham.gia, sanpham.gioitinh, sanpham.ngaytao, sanpham.DanhMuc_id, sanpham.KhuyenMai_id, sanpham.anhdaidien as hinhanh,  khuyenmai.thoigian_kt
                from  sanpham
                left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                where sanpham.ten LIKE '%$timKiem%' and ( $queryIn )
                LIMIT $offset,$limit
                ";
        }
        return $this->db->selectNonParam($query);
    }
    public function laySLSanPhamKhKhuyenMai($timKiem, $pro)
    {
        $query = "";
        if (count($pro) != 0) {
            $queryIn = "sanpham.id in (" . implode(',', $pro) . ") or (sanpham.KhuyenMai_id is null or (khuyenmai.thoigian_kt is not null and CURDATE() > khuyenmai.thoigian_kt ))";
        } else {
            $queryIn = "sanpham.KhuyenMai_id is null or (khuyenmai.thoigian_kt is not null and CURDATE() > khuyenmai.thoigian_kt )";
        }
        if ($timKiem == "") {
            $query = "select COUNT(*) as sl
            from sanpham
            left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
            where $queryIn";
        } else {
            $query = "select COUNT(*) as sl
            from sanpham
            left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
            where sanpham.ten LIKE '%$timKiem%' and ( $queryIn )";
        }
        $sl = $this->db->selectNonParam($query);
        return $sl[0]["sl"];
    }

    public function laySanPhamId($id)
    {
        return $this->db->selectNonParam("
        select sanpham.*, danhmuc.id as DanhMuc_id, danhmuc.ten as DanhMuc_ten, khuyenmai.phantram, khuyenmai.thoigian_kt, donhang.sosaotb, donhang.luotban
                from sanpham 
                inner join danhmuc on danhmuc.id = sanpham.DanhMuc_id
                left JOIN khuyenmai on sanpham.KhuyenMai_id = khuyenmai.id
                INNER join (
                    select kichcosanpham.SanPham_id, avg(sosaotb) as sosaotb, sum(luotban) as luotban 
                    from kichcosanpham
                    LEFT join (
                        select chitietdonhang.SanPham_id, avg(danhgiasanpham.sosao) as sosaotb, count(chitietdonhang.SanPham_id) as luotban
                        from chitietdonhang
                        INNER join donhang on donhang.id = chitietdonhang.DonHang_id
                        left join danhgiasanpham on danhgiasanpham.SanPham_id = chitietdonhang.SanPham_id and danhgiasanpham.DonHang_id = chitietdonhang.DonHang_id
                        where donhang.TrangThaiDonHang_id = 3
                        group by chitietdonhang.SanPham_id    
                    ) as donhang on donhang.SanPham_id = kichcosanpham.id
                    group by kichcosanpham.SanPham_id  
                ) as donhang on donhang.SanPham_id = sanpham.id
                where sanpham.id = $id;")[0];
    }

    public function layLoaiSanPhamId($id)
    {
        return $this->db->selectNonParam("select * from loaisanpham where SanPham_id = $id");
    }
    public function layKichCoSanPhamId($sanpham_id, $loaisanpham_id)
    {
        return $this->db->selectNonParam("select * from kichcosanpham where SanPham_id = $sanpham_id and LoaiSanPham_id = $loaisanpham_id");
    }

    public function layKichCoSanPhamId_($id)
    {
        return $this->db->selectNonParam("select * from kichcosanpham where SanPham_id = $id");
    }

    public function suaSanPham($data)
    {
        try {
            $this->db->conn->beginTransaction();
            $id = $this->fm->validation($data['id']);
            $ten = $this->fm->validation($data['ten']);
            $anhdaidien = $this->fm->validation($data['image1']);
            $mota = $this->fm->validation($data['mota']);
            $gia = $this->fm->validation($data['gia']);
            $gioitinh = $this->fm->validation($data['gioitinh']);
            $DanhMuc_id = $this->fm->validation($data['DanhMuc_id']);
            $query = "UPDATE sanpham     
        SET ten = '$ten', mota = '$mota', gia = $gia, gioitinh = '$gioitinh', DanhMuc_id = $DanhMuc_id, anhdaidien = '$anhdaidien'
        WHERE id = $id;";

            $this->db->updateNonParam($query);

            $loaiSanPham_h = json_decode(stripslashes($data['data']), true);
            $loaiSanPham_c = $this->layLoaiSanPhamId($id);
            $kcSanPham_s = [];
            $loaiSanPham_x = [];
            $loaiSanPham_m = array_filter(
                $loaiSanPham_h,
                function ($item) {
                    return $item['id'] <= 0;
                }
            );
            foreach ($loaiSanPham_c as $lspc) {
                $kt = null;
                foreach ($loaiSanPham_h as $lsph) {
                    if ($lspc['id'] == $lsph['id']) {
                        $kt = $lsph['option_value'];
                    }
                }
                if (is_null($kt)) {
                    array_push($loaiSanPham_x, $lspc);
                } else {
                    array_push($kcSanPham_s, $kt);
                }
            }
            $kcsp_c = $this->db->selectNonParam("select * from kichcosanpham where kichcosanpham.SanPham_id = $id");
            //them 124 - 235
            if (count($loaiSanPham_m) != 0) {
                foreach ($loaiSanPham_m as $lsp) {
                    $query = "insert into loaisanpham(mausac, hinhanh, SanPham_id)
                    values('" . $lsp["color"] . "', '" . $lsp["image"] . "', " . $id . ")
                ";
                    $loaiSanPham_id = $this->db->insertNonParam($query);
                    foreach ($lsp["option_value"] as $kcsp) {
                        $query_kcsp = "insert into kichcosanpham(kichco, soluong, SanPham_id, LoaiSanPham_id)
                        values('" . $kcsp["size"] . "', " . $kcsp["quantity"] . ", " . $id . ", " . $loaiSanPham_id . ")
                    ";
                        $kichCoSanPham_id = $this->db->insertNonParam($query_kcsp);
                    }
                }
            }
            //sua
            $queryU = "";
            foreach ($kcSanPham_s as $lsp) {
                foreach ($lsp as $kcsp) {
                    $kcsp_id = $kcsp['id'];
                    $kichco = $kcsp['size'];
                    $soluong = $kcsp['quantity'];
                    $queryU = $queryU . " UPDATE kichcosanpham 
                    SET kichco = '$kichco', soluong = $soluong
                    WHERE id = $kcsp_id;
                ";
                }
            }
            $this->db->updateNonParam($queryU);

            //xoa loai san pham 
            if (count($loaiSanPham_x) != 0) {
                $loaiSanPham_x = array_map(
                    fn ($d) => $d['id'],
                    $loaiSanPham_x
                );
                $kichcosanpham = $this->db->selectNonParam("select * from kichcosanpham where LoaiSanPham_id in( " . implode(",", $loaiSanPham_x) . ");");

                $kichcosanpham = array_map(
                    fn ($d) => $d['id'],
                    $kichcosanpham
                );
                $chiTietDonHang = $this->db->selectNonParam("select * from chitietdonhang where SanPham_id in( " . implode(",", $kichcosanpham) . ");");
                if (count($chiTietDonHang) != 0) {
                    $chiTietDonHang_SanPham_id = [];
                    $chiTietDonHang_DonHang_id = [];
                    $chiTietDonHang_SanPham_id = array_map(
                        fn ($d) => $d['SanPham_id'],
                        $chiTietDonHang
                    );
                    $chiTietDonHang_DonHang_id = array_map(
                        fn ($d) => $d['DonHang_id'],
                        $chiTietDonHang
                    );
                    $this->db->deleteNonParam("delete from danhgiasanpham where SanPham_id 
                    in (" . implode(',', $chiTietDonHang_SanPham_id) . ") and DonHang_id in (" . implode(',', $chiTietDonHang_DonHang_id) . ")");
                    $this->db->deleteNonParam("delete from chitietdonhang where SanPham_id 
                    in (" . implode(',', $chiTietDonHang_SanPham_id) . ") and DonHang_id in (" . implode(',', $chiTietDonHang_DonHang_id) . ")");
                }
                $this->db->deleteNonParam("delete from giohang where KichCoSanPham_id in( " . implode(",", $kichcosanpham) . ");");
                $this->db->deleteNonParam("delete from kichcosanpham where id in( " . implode(",", $kichcosanpham) . ");");
                $this->db->deleteNonParam("delete from loaisanpham where id in( " . implode(",", $loaiSanPham_x) . ") and SanPham_id = $id;");
            }
            // xoa kcsp

            $kcsp_xoa = [];

            foreach ($loaiSanPham_h as $itemL) {
                foreach ($itemL['option_value'] as $itemK) {
                    array_push($kcsp_xoa, $itemK);
                }
            }

            
            $kcsp_xoa1 = [];
            foreach ($kcsp_c as $item) {
                $arr = [];
                $arr = array_filter($kcsp_xoa, function ($value) use ($item) {
                    return $value['id'] == $item['id'];
                });
                if (count($arr) == 0) {
                    array_push($kcsp_xoa1, $item);
                }
            }

            if (count($kcsp_xoa1) != 0) {
                $kcsp_xoa1 = array_map(
                    fn ($d) => $d['id'],
                    $kcsp_xoa1
                );
                $chiTietDonHang = $this->db->selectNonParam("select * from chitietdonhang where SanPham_id in( " . implode(",", $kcsp_xoa1) . ");");
                if (count($chiTietDonHang) != 0) {
                    $chiTietDonHang_SanPham_id = [];
                    $chiTietDonHang_DonHang_id = [];
                    $chiTietDonHang_SanPham_id = array_map(
                        fn ($d) => $d['SanPham_id'],
                        $chiTietDonHang
                    );
                    $chiTietDonHang_DonHang_id = array_map(
                        fn ($d) => $d['DonHang_id'],
                        $chiTietDonHang
                    );
                    $this->db->deleteNonParam("delete from danhgiasanpham where SanPham_id 
                    in (" . implode(',', $chiTietDonHang_SanPham_id) . ") and DonHang_id in (" . implode(',', $chiTietDonHang_DonHang_id) . ")");
                    $this->db->deleteNonParam("delete from chitietdonhang where SanPham_id 
                    in (" . implode(',', $chiTietDonHang_SanPham_id) . ") and DonHang_id in (" . implode(',', $chiTietDonHang_DonHang_id) . ")");
                }
                $this->db->deleteNonParam("delete from giohang where KichCoSanPham_id in( " . implode(",", $kcsp_xoa1) . ");");
                $this->db->deleteNonParam("delete from kichcosanpham where id in( " . implode(",", $kcsp_xoa1) . ");");
            }

            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return false;
        }
    }

    public function xoaSanPham($id)
    {
        try {
            $this->db->conn->beginTransaction();
            //xoa danh gia va chitietdonhang
            $kichcosanpham = $this->db->selectNonParam("select * from kichcosanpham where SanPham_id = $id");

            $kichcosanpham = array_map(
                fn ($d) => $d['id'],
                $kichcosanpham
            );

            $chiTietDonHang = $this->db->selectNonParam("select * from chitietdonhang where SanPham_id in( " . implode(",", $kichcosanpham) . ");");

            if (count($chiTietDonHang) != 0) {
                $chiTietDonHang_SanPham_id = [];
                $chiTietDonHang_DonHang_id = [];
                $chiTietDonHang_SanPham_id = array_map(
                    fn ($d) => $d['SanPham_id'],
                    $chiTietDonHang
                );
                $chiTietDonHang_DonHang_id = array_map(
                    fn ($d) => $d['DonHang_id'],
                    $chiTietDonHang
                );
                $this->db->deleteNonParam("delete from danhgiasanpham where SanPham_id 
                in (" . implode(',', $chiTietDonHang_SanPham_id) . ") and DonHang_id in (" . implode(',', $chiTietDonHang_DonHang_id) . ")");
                $this->db->deleteNonParam("delete from chitietdonhang where SanPham_id 
                in (" . implode(',', $chiTietDonHang_SanPham_id) . ") and DonHang_id in (" . implode(',', $chiTietDonHang_DonHang_id) . ")");
                $this->db->deleteNonParam("delete from donhang where id in (" . implode(',', $chiTietDonHang_DonHang_id) . ")");
            }

            // xoa loaisanpham, kichco
            $this->db->deleteNonParam("delete from giohang where KichCoSanPham_id in( " . implode(",", $kichcosanpham) . ");");
            $this->db->deleteNonParam("delete from kichcosanpham where SanPham_id = $id");
            $this->db->deleteNonParam("delete from loaisanpham where SanPham_id = $id");
            $this->db->deleteNonParam("delete from sanpham where id = $id");
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return false;
        }
    }
    public function layDsBinhLuan($spId)
    {
        try {
            $dsBL = $this->db->selectNonParam("
            SELECT khachhang.ten, danhgiasanpham.sosao, danhgiasanpham.binhluan, danhgiasanpham.ngaytao, kichcosanpham.SanPham_id, loaisanpham.mausac, kichcosanpham.kichco
            from danhgiasanpham
            INNER join khachhang on khachhang.id = danhgiasanpham.KhachHang_id
            INNER join chitietdonhang on chitietdonhang.SanPham_id = danhgiasanpham.SanPham_id and chitietdonhang.DonHang_id = danhgiasanpham.DonHang_id
            INNER join kichcosanpham on kichcosanpham.id = chitietdonhang.SanPham_id
            INNER join loaisanpham on loaisanpham.id = kichcosanpham.LoaiSanPham_id and loaisanpham.SanPham_id = kichcosanpham.SanPham_id
            where kichcosanpham.SanPham_id = $spId
            order by danhgiasanpham.ngaytao desc;
            ");
            return $dsBL;
        } catch (PDOException $e) {
            return false;
        }
    }
}
