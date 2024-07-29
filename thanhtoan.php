<?php
include "./helpers/view.php";
include "./classes/Database.php";
include "./classes/KhachHang.php";
include_once('./helpers/Fomat.php');


view('header', ['title' => 'Thanh toán']);
if (!Session::checkAuth()) {
    echo "<script>location.href = 'dangnhap.php'</script>";
}

if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    echo "<script>location.href = 'index.php'</script>";
}
$dssp = [];
$tongTien = 0;
$phiVanChuyen = 0;
$loai = null;
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['typeCheckout'])) {
    $db = new Database();
    $fm = new Format();
    $kh = new KhachHang();
    $loai = (int)$_POST['typeCheckout'];
    try {
        $dsDiaChi = $kh->layDiaChi(Session::get("cusId"));


        if ($_POST['typeCheckout'] === "1") {
            // Array
            // (
            //     [id] => 19
            //     [color] => 6
            //     [size] => 11
            //     [quantity] => 1
            //     [typeCheckout] => 1
            // )
            $id = $fm->validation($_POST['id']);
            $color = $fm->validation($_POST['color']);
            $size = $fm->validation($_POST['size']);
            $quantity = $fm->validation($_POST['quantity']);

            $query = "select sanpham.id as spid, loaisanpham.id as lspid, kichcosanpham.id as kcspid, sanpham.ten, sanpham.gia, loaisanpham.hinhanh, loaisanpham.mausac, kichcosanpham.kichco, sanpham.KhuyenMai_id, khuyenmai.phantram, khuyenmai.thoigian_bd, thoigian_kt
                    from sanpham
                    inner join loaisanpham on sanpham.id = loaisanpham.SanPham_id
                    inner join kichcosanpham on loaisanpham.id = kichcosanpham.LoaiSanPham_id and loaisanpham.SanPham_id = kichcosanpham.SanPham_id
                    left join khuyenmai on khuyenmai.id = sanpham.KhuyenMai_id
                    where sanpham.id = $id and loaisanpham.id = $color and kichcosanpham.id = $size";
            $dssp = $db->selectNonParam($query);
            $dssp =  array_map(function ($item) {
                if (is_null($item['KhuyenMai_id'])) {
                    return [
                        "spid" => $item['spid'],
                        "lspid" => $item['lspid'],
                        "kcspid" => $item['kcspid'],
                        "ten" => $item['ten'],
                        "gia" => $item['gia'],
                        "hinhanh" => $item['hinhanh'],
                        "mausac" => $item['mausac'],
                        "kichco" => $item['kichco'],
                    ];
                } else {
                    if (is_null($item['thoigian_kt'])) {
                        return [
                            "spid" => $item['spid'],
                            "lspid" => $item['lspid'],
                            "kcspid" => $item['kcspid'],
                            "ten" => $item['ten'],
                            "gia" => (float)$item['gia'] - ((float)$item['gia'] * ((float)$item['phantram'] / 100)),
                            "hinhanh" => $item['hinhanh'],
                            "mausac" => $item['mausac'],
                            "kichco" => $item['kichco'],
                        ];
                    } else {
                        if (strtotime($item['thoigian_kt']) < strtotime(date('Y-m-d'))) {
                            return [
                                "spid" => $item['spid'],
                                "lspid" => $item['lspid'],
                                "kcspid" => $item['kcspid'],
                                "ten" => $item['ten'],
                                "gia" => $item['gia'],
                                "hinhanh" => $item['hinhanh'],
                                "mausac" => $item['mausac'],
                                "kichco" => $item['kichco'],
                            ];
                        } else {
                            return [
                                "spid" => $item['spid'],
                                "lspid" => $item['lspid'],
                                "kcspid" => $item['kcspid'],
                                "ten" => $item['ten'],
                                "gia" => (float)$item['gia'] - ((float)$item['gia'] * ((float)$item['phantram'] / 100)),
                                "hinhanh" => $item['hinhanh'],
                                "mausac" => $item['mausac'],
                                "kichco" => $item['kichco'],
                            ];
                        }
                    }
                }
            }, $dssp);
            $quantity = intval($quantity);
            $tongTien  = array_reduce($dssp, function ($previous, $current) use ($quantity) {
                return $previous + $current['gia'] * $quantity;
            });
            $phiVanChuyen = $tongTien >= 1000000 ? 0 : 32000;
        } else {
            // Array
            // (
            //     [sps] => Array
            //         (
            //             [0] => 25_64
            //             [1] => 9_19
            //         )

            //     [typeCheckout] => 0  - cusId
            // )
            $sps = implode(',', $_POST['sps']);
            $userid = Session::get("cusId");
            $query = "
                    select sanpham.id as spid, loaisanpham.id as lspid, kichcosanpham.id as kcspid, sanpham.ten, sanpham.gia, loaisanpham.hinhanh, loaisanpham.mausac, kichcosanpham.kichco, giohang.soluong, sanpham.KhuyenMai_id, khuyenmai.phantram, khuyenmai.thoigian_bd, thoigian_kt
                    from sanpham
                    inner join loaisanpham on sanpham.id = loaisanpham.SanPham_id
                    inner join kichcosanpham on loaisanpham.id = kichcosanpham.LoaiSanPham_id and loaisanpham.SanPham_id = kichcosanpham.SanPham_id
                    INNER JOIN giohang on giohang.KichCoSanPham_id = kichcosanpham.id
                    left join khuyenmai on khuyenmai.id = sanpham.KhuyenMai_id
                    where giohang.KhachHang_id = $userid and giohang.KichCoSanPham_id in ($sps)
                ";
            $dssp = $db->selectNonParam($query);
            $dssp =  array_map(function ($item) {
                if (is_null($item['KhuyenMai_id'])) {
                    return [
                        "spid" => $item['spid'],
                        "lspid" => $item['lspid'],
                        "kcspid" => $item['kcspid'],
                        "ten" => $item['ten'],
                        "gia" => $item['gia'],
                        "hinhanh" => $item['hinhanh'],
                        "mausac" => $item['mausac'],
                        "kichco" => $item['kichco'],
                        "soluong" => $item['soluong'],
                    ];
                } else {
                    if (is_null($item['thoigian_kt'])) {
                        return [
                            "spid" => $item['spid'],
                            "lspid" => $item['lspid'],
                            "kcspid" => $item['kcspid'],
                            "ten" => $item['ten'],
                            "gia" => (float)$item['gia'] - ((float)$item['gia'] * ((float)$item['phantram'] / 100)),
                            "hinhanh" => $item['hinhanh'],
                            "mausac" => $item['mausac'],
                            "kichco" => $item['kichco'],
                            "soluong" => $item['soluong'],
                        ];
                    } else {
                        if (strtotime($item['thoigian_kt']) < strtotime(date('Y-m-d'))) {
                            return [
                                "spid" => $item['spid'],
                                "lspid" => $item['lspid'],
                                "kcspid" => $item['kcspid'],
                                "ten" => $item['ten'],
                                "gia" => $item['gia'],
                                "hinhanh" => $item['hinhanh'],
                                "mausac" => $item['mausac'],
                                "kichco" => $item['kichco'],
                                "soluong" => $item['soluong'],
                            ];
                        } else {
                            return [
                                "spid" => $item['spid'],
                                "lspid" => $item['lspid'],
                                "kcspid" => $item['kcspid'],
                                "ten" => $item['ten'],
                                "gia" => (float)$item['gia'] - ((float)$item['gia'] * ((float)$item['phantram'] / 100)),
                                "hinhanh" => $item['hinhanh'],
                                "mausac" => $item['mausac'],
                                "kichco" => $item['kichco'],
                                "soluong" => $item['soluong'],
                            ];
                        }
                    }
                }
            }, $dssp);
            $tongTien  = array_reduce($dssp, function ($previous, $current) {
                return $previous + ($current['gia'] * $current['soluong']);
            });
            $phiVanChuyen = $tongTien >= 1000000 ? 0 : 32000;
        }
    } catch (PDOException $e) {
    }
}
?>

<main class="xl:container mx-auto lg:container sm:container">
    <?php echo count($dsDiaChi) === 0 ? '<div class="flex flex-col gap-5 mt-8">' : '<form action="_thanhtoan.php" method="POST" class="flex flex-col gap-5 mt-8">' ?>

    <div class="p-4 bg-white shadow-md border border-gray-200 rounded-md">
        <div class="flex justify-between items-center">
            <h2 class="text-rose-500 md:text-xl text-lg capitalize flex items-center gap-3"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                </svg>Địa Chỉ Nhận Hàng</h2>
            <?php if (isset($dsDiaChi) && count($dsDiaChi) != 0) : ?>
                <button type="button" class="btn-change cursor-pointer bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-400 focus:bg-blue-400">Thay đổi</button>
            <?php else : ?>
                <form action="thongtin.php" method="POST">
                    <?php if ($_POST['typeCheckout'] === "1") : ?>
                        <input type="text" name="id" class="sr-only" value="<?php echo $_POST['id'] ?? "" ?>">
                        <input type="text" name="color" class="sr-only" value="<?php echo $_POST['color'] ?? "" ?>">
                        <input type="text" name="size" class="sr-only" value="<?php echo $_POST['size'] ?? "" ?>">
                        <input type="text" name="quantity" class="sr-only" value="<?php echo $_POST['quantity'] ?? "" ?>">
                    <?php else : ?>
                        <?php foreach ($_POST['sps'] as $item) : ?>
                            <input type="checkbox" checked name="sps[]" class="sr-only" value="<?php echo $item ?? "" ?>">
                        <?php endforeach; ?>
                        <input type="checkbox" name="sps[]" class="sr-only" value="<?php echo $_POST['id'] ?? "" ?>">
                    <?php endif; ?>
                    <input type="text" name="typeCheckout" class="sr-only" value="<?php echo $_POST['typeCheckout'] ?? "" ?>">
                    <button type="submit" class="cursor-pointer bg-blue-600 text-white rounded-md py-2 px-4 hover:bg-blue-400 focus:bg-blue-400">Thêm địa chỉ</button>
                </form>

            <?php endif; ?>
        </div>
        <div class="mt-2 text-gray-800">
            <input type="text" class="peer sr-only" value="<?php echo $dsDiaChi[0]['id'] ?? "-999" ?>" name="addressId">
            <input type="text" class="peer sr-only" value="<?php echo Session::get("cusId") ?? "0" ?>" name="userId">
            <div class=" md:text-lg text-base ">
                <strong><?php echo Session::get("cusName") ?? "" ?></strong>
                <span class="addressPhone">
                    | <?php
                        if (isset($dsDiaChi) && count($dsDiaChi) != 0) {
                            echo "+ " . $dsDiaChi[0]['sdt'];
                        }
                        ?>
                </span>
            </div>
            <p class="addressDetails md:text-lg text-base">
                <?php
                if (isset($dsDiaChi) && count($dsDiaChi) != 0) {
                    echo $dsDiaChi[0]['diachicuthe'] . ", " . $dsDiaChi[0]['diachi'];
                }
                ?></p>
        </div>
    </div>
    <div class="relative p-4 bg-white overflow-x-auto shadow-md border border-gray-200 rounded-md">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap font-semibold ">Sản Phẩm</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap"></th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap"></th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Đơn Giá</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Số Lượng</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dssp as $sp) : ?>
                    <tr class="bg-white border-b ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                            <img class="h-12 w-12" src="<?php echo $sp['hinhanh'] ?? "" ?>">
                            <input type="checkbox" checked class="peer sr-only" name="sp[]" value="<?php
                                                                                                    if (array_key_exists("soluong", $sp)) {
                                                                                                        echo $sp['kcspid'] . "_" .    $sp['soluong'];
                                                                                                    } else {
                                                                                                        echo $sp['kcspid'] . "_" .    $quantity;
                                                                                                    }
                                                                                                    ?>">
                        </th>
                        <td class="px-6 py-4 ">
                            <h4 class="line-clamp-1 md:text-base text-sm"><?php echo $sp['ten'] ?? "" ?></h4>
                        </td>
                        <td class="px-6 py-4 capitalize">
                            <h6 class="line-clamp-2 md:text-sm text-xs"><?php echo "Loại: " . ($sp['mausac'] ?? "") . " - " . $sp['kichco'] ?? "" ?></h6>
                        </td>
                        <td class="px-6 py-4 font-semibold whitespace-nowrap"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $sp['soluong'] ?? $quantity ?></td>
                        <td class="px-6 py-4 font-semibold text-rose-500 whitespace-nowrap"><?php
                                                                                            if (isset($sp['soluong'])) {
                                                                                                echo "đ " . number_format($sp["gia"] * $sp["soluong"], 0, '', ',');
                                                                                            } else {
                                                                                                echo "đ " . number_format($sp["gia"] * $quantity, 0, '', ',');
                                                                                            }
                                                                                            ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 bg-white shadow-md border border-gray-200 rounded-md">
        <h2 class="md:text-xl text-lg capitalize flex items-center gap-3">Phương Thức Thanh Toán</h2>
        <ul class="mt-3">
            <label class="cursor-pointer flex items-center">
                <input type="radio" checked name="color" class="accent-rose-500 w-4 h-4" value="5">
                <p class="ml-3 flex gap-2 md:text-sm text-xs text-gray-800 items-center">
                    <img class="h-8 w-8" src="./public/images/img-odcod.webp" alt="">
                    Thanh toán khi nhận hàng (COD)
                </p>
            </label>
            <label class="cursor-pointer flex items-center mt-3">
                <input type="radio"  name="color" class="accent-rose-500 w-4 h-4" value="5">
                <p class="ml-3 flex gap-2 md:text-sm text-xs text-gray-800 items-center">
                    <img class="h-8 w-8" src="./public/images/img-odmm.jpg" alt="">
                    Thanh toán qua MoMo
                </p>
            </label>
        </ul>
    </div>
    <div class="p-4 bg-white shadow-md border border-gray-200 rounded-md">
        <div class="flex items-center justify-between">
            <h2 class="md:text-xl text-lg capitalize flex items-center gap-3"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-rose-500" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 5H3a1 1 0 0 0-1 1v4h.893c.996 0 1.92.681 2.08 1.664A2.001 2.001 0 0 1 3 14H2v4a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-4h-1a2.001 2.001 0 0 1-1.973-2.336c.16-.983 1.084-1.664 2.08-1.664H22V6a1 1 0 0 0-1-1zM9 9a1 1 0 1 1 0 2 1 1 0 1 1 0-2zm-.8 6.4 6-8 1.6 1.2-6 8-1.6-1.2zM15 15a1 1 0 1 1 0-2 1 1 0 1 1 0 2z"></path>
                </svg></h2>
        </div>
        <div class="mt-2 flex md:flex-row flex-col md:items-center md:justify-between gap-2"></div>
        <div class="lg:w-80 md:w-72  md:float-right">
            <h4 class="md:text-base text-sm flex justify-between items-center pb-2">Tổng tiền hàng:<span><?php echo "đ " . number_format($tongTien, 0, '', ',')  ?></span></h4>
            <h4 class="md:text-base text-sm flex justify-between items-center pb-2">Phí vận chuyển:<span><?php echo "đ " . number_format($phiVanChuyen, 0, '', ',')  ?></span></h4>
            <h4 class="md:text-lg text-base flex justify-between items-center pb-2">Tổng thanh toán:<strong class="text-rose-500 md:text-2xl text-lg"><?php echo "đ " . number_format($tongTien + $phiVanChuyen, 0, '', ',')  ?></strong></h4>
        </div>
        <div class="clear-both"></div>
        <div class="md:mt-8 mt-4   flex md:items-center md:flex-row flex-col md:gap-0 gap-2 md:justify-between">
            <p>Nhấn "Đặt hàng" đồng nghĩa với việc bạn đồng ý tuân theo <a class="text-blue-600 hover:text-blue-500" href="#">Điều khoản Shop</a></p>
            <?php if (isset($dsDiaChi) && count($dsDiaChi) != 0) : ?>
                <button type="submit" class=" px-6 rounded-s py-3 bg-green-500 hover:bg-green-400 text-white">Dặt hàng</button>
            <?php else : ?>
                <button type="button" disabled="" class="cursor-not-allowed focus:outline-none opacity-50 px-6 rounded-s py-3 bg-green-500 hover:bg-green-400 text-white">Dặt hàng</button>
            <?php endif; ?>
        </div>
    </div>

    <?php echo count($dsDiaChi) === 0 ? '</div>' : '</form>' ?>
</main>
<div id="modal-address" class="hidden fixed inset-0 transition z-[200]">
    <div class="absolute inset-0"></div>
    <div id="container__search" class="bg-gray-600 bg-opacity-40 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
        <div class="container mx-auto">
            <form id="formAd" method="POST" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                <h4 class="pb-2 md:text-lg text-md border-b border-gray-300">Địa chỉ của tôi</h4>
                <div class="divide-y divide-gray-300">
                    <?php if (isset($dsDiaChi) && count($dsDiaChi) != 0) : ?>

                        <?php foreach ($dsDiaChi as $item) : ?>
                            <div class=" text-gray-800">
                                <div class="px-2 py-3  flex items-start gap-2">
                                    <label for="address">
                                        <input <?php echo $item['macdinh'] == 1 ? "checked" : "" ?> type="radio" value="<?php echo $item['id'] ?? "-999" ?>" name="address" class="w-4 h-4 accent-blue-500 text-blue-600 bg-gray-100 border-gray-300   w-4 h-4 ">
                                    </label>
                                    <div>
                                        <h6>+ <?php echo $item['sdt'] ?? "0" ?></h6>
                                        <p><?php echo $item['diachicuthe'] . ", " . $item['diachi'] ?></p>
                                        <?php if ($item['macdinh'] == 1) : ?>
                                            <span class="mt-2 inline-block py-0.5 px-1 text-xs text-red-500 border border-red-500 rounded-md">Mặc định</span>
                                        <?php else : ?>
                                            <span class="mt-2 inline-block py-0.5 px-1 text-xs text-gray-400 border border-gray-400 rounded-md">Địa chỉ lấy hàng</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-3 justify-end">
                    <button id="btn-close-modalAd" type="button" class="text-gray-800  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Trở lại</button>
                    <button id="btn-add-modalAd" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/navbar.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/cart.js"></script>
<script>
    let selectedId = document.querySelector("input[type='radio'][name=address]:checked")?.value; // type string
    let arrAddress = <?php echo json_encode($dsDiaChi) ?? '[]' ?>;
    
    const modal = document.querySelector("#modal-address");
    const form = document.querySelector("#formAd");
    // open modal
    document.querySelector(".btn-change")?.addEventListener("click", () => {
        modal.classList.remove("hidden");
        modal.classList.add("fixed");
    });
    // close modal
    document.querySelector("#btn-close-modalAd").addEventListener("click", () => {
        modal.classList.remove("fixed");
        modal.classList.add("hidden");
    });

    //submit
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        if (document.querySelector("input[type='radio'][name=address]:checked").value === selectedId){
            
        }
        else {
            selectedId = document.querySelector("input[type='radio'][name=address]:checked").value;
            let address = arrAddress.find(item => parseInt(item.id) === parseInt(selectedId));
            document.querySelector("input[name='addressId']").value = address['id'];
            document.querySelector(".addressPhone").innerHTML = address['sdt'];
            document.querySelector(".addressDetails").innerHTML = address['diachicuthe'] + ", " + address['diachi'];
        }
        modal.classList.remove("fixed");
        modal.classList.add("hidden");
    })
</script>
</body>

</html>