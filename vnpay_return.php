<?php
include "./helpers/view.php";

view('header', ['title' => 'Thanh toán']);
if (!Session::checkAuth()) {
    echo "<script>location.href = 'dangnhap.php'</script>";
}

if (isset($_GET['vnp_SecureHash'], $_GET['userId'], $_GET['sp'], $_GET['addressId'])) {
    require_once(__DIR__ .  "/vnpay/config_vnpay.php");
    // 
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }
    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }
    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    if ($secureHash == $vnp_SecureHash) {
        if ($_GET['vnp_ResponseCode'] == '00') {
            include "./classes/DonHang.php";
            include "./classes/GuiMailDonHang.php";
            include_once "./classes/Database.php";
            $dh = new DonHang();
            $post_data = [
                "userId" => $_GET['userId'],
                "addressId" => $_GET['addressId'],
                "sp" => json_decode($_GET['sp'], true),
                "isThanhToan" => 1
            ];
            $themDonHang = $dh->themDonHang($post_data);
            if ($themDonHang) {
                $db = new Database();
                $dsspdh = $db->selectNonParam("
            select donhang.id, donhang.TrangThaiDonHang_id, donhang.tongtien, donhang.ngaytao, donhang.ngaysua, donhang.diachi, trangthaidonhang.trangthai, 
            chitietdonhang.gia, chitietdonhang.soluong, sanpham.id as SanPham_id, kichcosanpham.id as KichCoSanPham_id, 
            sanpham.ten, loaisanpham.mausac, loaisanpham.hinhanh, kichcosanpham.kichco, danhgiasanpham.DonHang_id as danhgiasanpham_id
            from donhang
            INNER JOIN trangthaidonhang on trangthaidonhang.id = donhang.TrangThaiDonHang_id
            INNER join chitietdonhang on donhang.id = chitietdonhang.DonHang_id
            INNER JOIN kichcosanpham on kichcosanpham.id = chitietdonhang.SanPham_id
            inner join loaisanpham on loaisanpham.id = kichcosanpham.LoaiSanPham_id and loaisanpham.SanPham_id = kichcosanpham.SanPham_id
            inner join sanpham on sanpham.id = loaisanpham.SanPham_id
            left join danhgiasanpham on danhgiasanpham.DonHang_id = chitietdonhang.DonHang_id and danhgiasanpham.SanPham_id = chitietdonhang.SanPham_id
            where donhang.id = $themDonHang
            ");
                $dssp_String = "";
                foreach ($dsspdh as $item) {
                    $dssp_String .= '
                <tr>
                <td style="padding-bottom:10px">
                    <table style="width:100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                            <td>
                                <img src="' . $item['hinhanh'] . '" width="100" height="100" alt="" style="float:left;margin-right:10px" class="CToWUd" data-bit="iit">
                            </td>
                            <td>
                            <div style="font-weight:700;text-transform:uppercase;margin-bottom:5px">' . $item['ten'] . '</div>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
                <td style="vertical-align:top;text-align:right;padding-bottom:10px">' . $item['gia'] . ' ₫  </td>
                <td style="vertical-align:top;text-align:center;padding-bottom:10px">' . $item['soluong'] . '</td>

                <td style="vertical-align:top;padding-bottom:10px;text-align:right"> ' . floatval($item['gia']) * floatval($item['soluong']) . ' ₫</td>
            </tr>
                ';
                }
                $content = '
            <table style="font-family:arial;line-height:16px;font-size:13px;background-color:#f8f8f8;width:100%;color:#414141">
            <tbody><tr>
                <td>
                    <table style="border-style:solid;border-color:#e5e5e5;border-width:1px;background-color:#fff;width:600px;margin-left:auto;margin-right:auto" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                            <td style="text-align:center">
                                <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
                                    <tbody>
                                </tbody></table>
                            </td>
                        </tr>
                        <tr><td><section>s
                                </section></td></tr><tr>
                <td style="padding-top:20px;padding-bottom:10px;padding-left:10px;padding-right:10px">
                    <div style="font-size:17px;margin-bottom:15px"><strong>Cảm ơn quý khách đã đặt hàng tại MMM</a></strong></div>
                    <div style="margin-bottom:15px">MMM rất vui thông báo đơn hàng 
                    <span style="color:#336e51">
                        24052454375
                        </span> của quý khách đang trong quá trình đóng gói.<br>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px">
                    <table style="border-style:solid;border-color:#f0f2f0;border-width:1px;width:100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                        </tr>
                        <tr>
                            <td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px">
                                <p><b>Địa chỉ giao hàng</b></p>
                                <div style="margin-bottom:20px"> <br>
                                   ' . $item['diachi'] . '
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px">
                    <table style="border-style:solid;border-color:#f0f2f0;border-width:1px;width:100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                            <td style="background-color:#f0f2f0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;font-weight:700"><div>CHI TIẾT ĐƠN HÀNG</div></td>
                        </tr>
                        <tr>
                            <td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px">
                                <table style="width:100%" cellpadding="0" cellspacing="0" border="0">
                                    <tbody><tr>
                                        <td width="320px" style="padding-bottom:10px"><b>Sản phẩm</b></td>
                                        <td width="80px" style="text-align:right;padding-bottom:10px"><b>Đơn giá </b></td>
                                        <td width="100px" style="text-align:center;padding-bottom:10px"><b>Số Lượng</b></td>
                                        <td width="100px" style="text-align:right;padding-bottom:10px"><b>Thành tiền</b></td>
                                    </tr> 
                                    ' . $dssp_String . '
                                    <td colspan="3" width="500" style="text-align:right;border-top-style:solid;border-top-color:#e5e5e5;border-top-width:1px;padding-top:10px">Thành tiền:</td>
                                <td style="vertical-align:top;padding-bottom:10px;text-align:right;font-weight:700;border-top-style:solid;border-top-color:#e5e5e5;border-top-width:1px;padding-top:10px">' . $item['tongtien'] . ' ₫</td>
                            </tr>

                            <tr>
                                <td colspan="3" width="500" style="text-align:right">Chi phí vận chuyển:</td>
                                <td style="vertical-align:top;padding-bottom:10px;text-align:right;font-weight:700">0 ₫</td>
                            </tr>
                                                                                                                                                                            <tr>
                                <td colspan="3" width="500" style="text-align:right">Tổng cộng:</td>
                                <td style="vertical-align:top;padding-bottom:10px;text-align:right;font-weight:700">' . $item['tongtien'] . ' ₫</td>
                            </tr>
                            </tr>
                                                                                                                                                                            <tr>
                                <td colspan="3" width="500" style="text-align:right">Đã thanh toán</td>
                                <td></td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
            </tbody>
        </table>
        </td>
    </tr>
    <tr>
       
    </tr>

</tbody></table>
            ';
                $kh = new GuiMailDonHang();
                $send = $kh->guiEmail($_SESSION['cusEmail'], "Đơn hàng #" . $themDonHang, $content);
            }
        } else {
            $themDonHang = false;
        }
    }
} else {
    echo "<script>location.href = 'index.php'</script>";
}

?>
<main class="xl:container mx-auto lg:container sm:container">
    <div class="flex h-[90vh] items-center justify-center  ">
        <div class="p-4 rounded-md shadow-md md:mx-0 mx-6 border-2 <?php echo $themDonHang ? 'border-green-500' : 'border-red-500' ?>">
            <?php if (isset($themDonHang) && $themDonHang == true) : ?>
                <div class="">
                    <svg class="mx-auto my-0 md:w-20 md:h-20 w-12 h-12 text-green-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="py-3 font-semibold text-center md:text-xl text-lg">Đặt hàng thành công</h3>
                <p class="py-3 text-gray-700 md:text-base text-sm text-justify">Cùng MMM bảo vệ quyền lợi của bạn - chỉ nhận hàng & thanh toán khi đơn hàng ở trạng thái "Đang giao hàng".</p>
                <div class="text-center flex py-3 items-center md:text-base text-sm text-gray-800">
                    <label>Mã GD Tại VNPAY:</label>
                    <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                </div>
                <div class="flex items-center justify-center gap-3">
                    <a href="index.php" class="cursor-pointer  px-4 py-2 border border-gray-300 text-gray-900 rounded-md">Trang chủ</a>
                    <a href="donhang.php#dangva%%chuye%%n" class="cursor-pointer hover:bg-green-400 px-4 py-2 border  text-white bg-green-500 rounded-md">Đơn mua</a>
                </div>
            <?php else : ?>
                <div class="">
                    <svg class="mx-auto my-0 md:w-20 md:h-20 w-12 h-12 text-red-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="py-3 font-semibold text-center md:text-xl text-lg">Đặt hàng không thành công</h3>
                <p class="py-3 text-gray-700 md:text-base text-sm text-justify">Đã xảy ra lỗi. Vui lòng thử lại!</p>
                <div class="flex items-center justify-center gap-3">
                    <a href="index.php" class="cursor-pointer  px-4 py-2 border border-gray-300 text-gray-900 rounded-md">Trang chủ</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>
</body>

</html>

<script type="text/javascript" src="<?php __DIR__ ?>public/js/navbar.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/cart.js"></script>