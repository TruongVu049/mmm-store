<?php
include "./helpers/view.php";
require_once("classes/Database.php");
view('header', ['title' => 'Trang chủ']);


$db = new Database();

$dsspmn = $db->selectNonParam("select sanpham.id, sanpham.ten, sanpham.gia, sanpham.gioitinh, sanpham.ngaytao, sanpham.DanhMuc_id, sanpham.KhuyenMai_id, sanpham.anhdaidien as hinhanh, khuyenmai.thoigian_kt, khuyenmai.phantram, donhang.sosaotb, donhang.luotban
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
 order by donhang.luotban desc 
 limit 0, 5");

$dsspdx = $db->selectNonParam("
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
                 order by sanpham.ngaytao desc 
                 limit 0, 5

");

?>
<div class="xl:container mx-auto lg:container sm:container pt-8 ">
    <div class="relative flex flex-col mb-12 overflow-hidden text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <!-- Item 1 -->
                <div class="duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-0 z-20" data-carousel-item>
                    <img src="./public/images/banner-1.webp" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <!-- Item 2 -->
                <div class="duration-700 ease-in-out absolute inset-0 transition-transform transform z-10 translate-x-full" data-carousel-item>
                    <img src="./public/images/banner-2.webp" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <!-- Item 3 -->
                <div class="duration-700 ease-in-out absolute inset-0 transition-transform transform -translate-x-full z-10 hidden" data-carousel-item>
                    <img src="./public/images/banner-3.webp" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <!-- Item 4 -->
                <div class="duration-700 ease-in-out absolute inset-0 transition-transform transform -translate-x-full z-10 hidden" data-carousel-item>
                    <img src="https://flowbite.com/docs/images/carousel/carousel-4.svg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <!-- Item 5 -->
                <div class="duration-700 ease-in-out absolute inset-0 transition-transform transform -translate-x-full z-10" data-carousel-item>
                    <img src="https://flowbite.com/docs/images/carousel/carousel-5.svg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

    </div>

</div>
<main class="xl:container mx-auto lg:container sm:container px-2    ">
    <!-- =================== Categories ======================== -->
    <div class="pb-4">
        <h2 class="mb-2 block font-sans text-2xl font-semibold leading-[1.3] tracking-normal text-gray-900 antialiased">
            Danh mục
        </h2>
        <div class="grid md:grid-cols-4 grid-cols-2 md:gap-4 gap-3">
            <a href="sanpham.php?p=1&sx=ngaytao_desc" class="group block max-w-sm md:p-4 p-2 bg-white  ">
                <div>
                    <div class="border-2 border-gray-200 rounded-lg shadow  group-hover:border-[#00c16a]">
                        <img class="md:w-32 md:h-32 w-24 h-20" src="<?php __DIR__ ?>public/images/ctgr_p.png" alt="">
                    </div>
                    <p class="font-normal text-gray-700 md:text-xl text-md text-center md:pt-4 pt-2">Sản Phẩm Mới</p>
                </div>
            </a>
            <a href="#" class="group block max-w-sm md:p-4 p-2 bg-white  ">
                <div>
                    <div class="border-2 border-gray-200 rounded-lg shadow  group-hover:border-[#00c16a]">
                        <img class="md:w-32 md:h-32 w-24 h-20" src="<?php __DIR__ ?>public/images/ctgr_s.png" alt="">
                    </div>
                    <p class="font-normal text-gray-700 md:text-xl text-md text-center md:pt-4 pt-2">Giảm Giá</p>
                </div>
            </a>
            <a href="sanpham.php?ft_gioitinh%5B%5D=nam&p=1&gia_nn=0&gia_ln=5000000" class="group block max-w-sm md:p-4 p-2 bg-white  ">
                <div>
                    <div class="border-2 border-gray-200 rounded-lg shadow  group-hover:border-[#00c16a]">
                        <img class="md:w-32 md:h-32 w-24 h-20" src="<?php __DIR__ ?>public/images/ctgr_b.png" alt="">
                    </div>
                    <p class="font-normal text-gray-700 md:text-xl text-md text-center md:pt-4 pt-2">Bé Nam</p>
                </div>
            </a>
            <a href="sanpham.php?ft_gioitinh%5B%5D=n%E1%BB%AF&p=1&gia_nn=0&gia_ln=5000000" class="group block max-w-sm md:p-4 p-2 bg-white  ">
                <div>
                    <div class="border-2 border-gray-200 rounded-lg shadow  group-hover:border-[#00c16a]">
                        <img class="md:w-32 md:h-32 w-24 h-20" src="<?php __DIR__ ?>public/images/ctgr_g.png" alt="">
                    </div>
                    <p class="font-normal text-gray-700 md:text-xl text-md text-center md:pt-4 pt-2">Bé Nữ</p>
                </div>
            </a>
        </div>
    </div>
    <div class="pb-4">
        <div class="flex sm:items-center justify-between sm:flex-row flex-col">
            <h2 class="mb-2 block font-sans text-2xl font-semibold leading-[1.3] tracking-normal text-gray-900 antialiased">
                Sản Phẩm Bán Chạy
            </h2>
            <a href="sanpham.php" class="sm:ml-0 ml-auto flex items-center md:text-lg text-md group text-green-600 hover:text-green-500">Xem tất cả
                <svg class="w-6 h-6 text-green-600 group-hover:text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4" />
                </svg>
            </a>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-6 py-4">
            <?php if (isset($dsspmn) && count($dsspmn) != 0) : ?>
                <?php
                foreach ($dsspmn as $sp) { ?>
                    <div class="relative hover:border-[#00c16a] flex w-full  flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
                        <a href="chitietsanpham.php?spid=<?php echo $sp['id'] ?>" class="block h-full">
                            <div class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-xl">
                                <img class="object-cover w-[100%]" src="<?php echo $sp['hinhanh'] ?>" alt="product image" />
                                <span class="<?php
                                                if (is_null($sp['KhuyenMai_id'])) {
                                                    echo "hidden";
                                                } else {
                                                    if (is_null($sp['thoigian_kt'])) {
                                                        echo "";
                                                    } else {
                                                        if (strtotime($sp['thoigian_kt']) > strtotime(date('Y-m-d'))) {
                                                            echo "";
                                                        } else {
                                                            echo "hidden";
                                                        }
                                                    }
                                                }
                                                ?> absolute top-0 left-0 m-2 rounded-full bg-rose-500  px-2 text-center text-sm font-medium text-white">Giảm <?php echo $sp['phantram'] ?>%</span>
                            </div>
                            <div class="mt-4 px-5 pb-5 h-[calc(100%-16rem)]">
                                <div class="flex flex-col justify-between h-full">
                                    <h5 class="lg:text-lg md:text-base text-sm tracking-tight text-slate-900"><?php
                                                                                                                if (strlen($sp['ten']) > 72) {
                                                                                                                    echo substr($sp['ten'], 0, 72) . "...";
                                                                                                                } else {
                                                                                                                    echo $sp['ten'];
                                                                                                                }
                                                                                                                ?></h5>
                                    <div class="mb-4">
                                        <div class="mt-2 mb-2 flex items-center justify-between ">

                                            <div class="flex items-center">

                                                <?php
                                                $strStar = "";
                                                for ($i = 1; $i <= 5; $i++) { //3.3
                                                    if (floatval($sp['sosaotb']) >= $i) {
                                                        $strStar .= '<svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                            <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                                                            </svg>  ';
                                                    } else {
                                                        if (floatval($sp['sosaotb']) / 10 >= 0.5) {
                                                            $strStar .= '
                                                                            <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                                <path fill-rule="evenodd" d="M13 4.024v-.005c0-.053.002-.353-.217-.632a1.013 1.013 0 0 0-1.176-.315c-.192.076-.315.193-.35.225-.052.05-.094.1-.122.134a4.358 4.358 0 0 0-.31.457c-.207.343-.484.84-.773 1.375a168.719 168.719 0 0 0-1.606 3.074h-.002l-4.599.367c-1.775.14-2.495 2.339-1.143 3.488L6.17 15.14l-1.06 4.406c-.412 1.72 1.472 3.078 2.992 2.157l3.94-2.388c.592-.359.958-.996.958-1.692v-13.6Zm-2.002 0v.025-.025Z" clip-rule="evenodd" />
                                                                            </svg>
                                                                            ';
                                                        } else {
                                                            $strStar .= '
                                                                            <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                                <path stroke="currentColor" stroke-width="2" d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z" />
                                                                            </svg>
                                                                            ';
                                                        }
                                                    }
                                                }
                                                echo $strStar;
                                                ?>
                                                <span class="mr-2 ml-3  px-2.5 py-0.5 text-xs text-gray-500"><?php echo is_null($sp['luotban']) ? '' : 'Đã bán ' . $sp['luotban'] ?></span>
                                            </div>
                                        </div>
                                        <span class="text-rose-500 md:text-xl text-lg">
                                            <?php
                                            if (is_null($sp['KhuyenMai_id'])) { ?>
                                                <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>
                                                <?php } else {
                                                if (is_null($sp['thoigian_kt'])) { ?>
                                                    <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"] - ($sp["gia"] * ((float)$sp['phantram'] / 100)), 0, '', ',')  ?></strong>
                                                    <strong class="text-sm text-gray-500 opacity-80 line-through"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>
                                                    <?php } else {
                                                    if (strtotime($sp['thoigian_kt']) > strtotime(date('Y-m-d'))) { ?>
                                                        <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"] - ($sp["gia"] * ((float)$sp['phantram'] / 100)), 0, '', ',')  ?></strong>
                                                        <strong class="text-sm text-gray-500 opacity-80 line-through"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>
                                                    <?php } else { ?>
                                                        <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>

                                            <?php }
                                                }
                                            }


                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php }
                ?>

            <?php else : ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="pb-4">
        <div class="flex sm:items-center justify-between sm:flex-row flex-col">
            <h2 class="mb-2 block font-sans text-2xl font-semibold leading-[1.3] tracking-normal text-gray-900 antialiased">
                Sản Phẩm Được Đề Xuất
            </h2>
            <a href="sanpham.php" class="sm:ml-0 ml-auto flex items-center md:text-lg text-md group text-green-600 hover:text-green-500">Xem tất cả
                <svg class="w-6 h-6 text-green-600 group-hover:text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4" />
                </svg>
            </a>
        </div>
        <div class="grid xl:grid-cols-5 lg:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-6 py-4">
            <?php if (isset($dsspdx) && count($dsspdx) != 0) : ?>
                <?php
                foreach ($dsspdx as $sp) { ?>
                    <div class="relative hover:border-[#00c16a] flex w-full  flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
                        <a href="chitietsanpham.php?spid=<?php echo $sp['id'] ?>" class="block h-full">
                            <div class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-xl">
                                <img class="object-cover w-[100%]" src="<?php echo $sp['hinhanh'] ?>" alt="product image" />
                                <span class="<?php
                                                if (is_null($sp['KhuyenMai_id'])) {
                                                    echo "hidden";
                                                } else {
                                                    if (is_null($sp['thoigian_kt'])) {
                                                        echo "";
                                                    } else {
                                                        if (strtotime($sp['thoigian_kt']) > strtotime(date('Y-m-d'))) {
                                                            echo "";
                                                        } else {
                                                            echo "hidden";
                                                        }
                                                    }
                                                }
                                                ?> absolute top-0 left-0 m-2 rounded-full bg-rose-500  px-2 text-center text-sm font-medium text-white">Giảm <?php echo $sp['phantram'] ?>%</span>
                            </div>
                            <div class="mt-4 px-5 pb-5 h-[calc(100%-16rem)]">
                                <div class="flex flex-col justify-between h-full">
                                    <h5 class="lg:text-lg md:text-base text-sm tracking-tight text-slate-900"><?php
                                                                                                                if (strlen($sp['ten']) > 72) {
                                                                                                                    echo substr($sp['ten'], 0, 72) . "...";
                                                                                                                } else {
                                                                                                                    echo $sp['ten'];
                                                                                                                }
                                                                                                                ?></h5>
                                    <div class="mb-4">
                                        <div class="mt-2 mb-2 flex items-center justify-between ">

                                            <div class="flex items-center">

                                                <?php
                                                $strStar = "";
                                                for ($i = 1; $i <= 5; $i++) { //3.3
                                                    if (floatval($sp['sosaotb']) >= $i) {
                                                        $strStar .= '<svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                            <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                                                            </svg>  ';
                                                    } else {
                                                        if (floatval($sp['sosaotb']) / 10 >= 0.5) {
                                                            $strStar .= '
                                                                            <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                                <path fill-rule="evenodd" d="M13 4.024v-.005c0-.053.002-.353-.217-.632a1.013 1.013 0 0 0-1.176-.315c-.192.076-.315.193-.35.225-.052.05-.094.1-.122.134a4.358 4.358 0 0 0-.31.457c-.207.343-.484.84-.773 1.375a168.719 168.719 0 0 0-1.606 3.074h-.002l-4.599.367c-1.775.14-2.495 2.339-1.143 3.488L6.17 15.14l-1.06 4.406c-.412 1.72 1.472 3.078 2.992 2.157l3.94-2.388c.592-.359.958-.996.958-1.692v-13.6Zm-2.002 0v.025-.025Z" clip-rule="evenodd" />
                                                                            </svg>
                                                                            ';
                                                        } else {
                                                            $strStar .= '
                                                                            <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                                <path stroke="currentColor" stroke-width="2" d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z" />
                                                                            </svg>
                                                                            ';
                                                        }
                                                    }
                                                }
                                                echo $strStar;
                                                ?>
                                                <span class="mr-2 ml-3  px-2.5 py-0.5 text-xs text-gray-500"><?php echo is_null($sp['luotban']) ? '' : 'Đã bán ' . $sp['luotban'] ?></span>
                                            </div>
                                        </div>
                                        <span class="text-rose-500 md:text-xl text-lg">
                                            <?php
                                            if (is_null($sp['KhuyenMai_id'])) { ?>
                                                <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>
                                                <?php } else {
                                                if (is_null($sp['thoigian_kt'])) { ?>
                                                    <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"] - ($sp["gia"] * ((float)$sp['phantram'] / 100)), 0, '', ',')  ?></strong>
                                                    <strong class="text-sm text-gray-500 opacity-80 line-through"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>
                                                    <?php } else {
                                                    if (strtotime($sp['thoigian_kt']) > strtotime(date('Y-m-d'))) { ?>
                                                        <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"] - ($sp["gia"] * ((float)$sp['phantram'] / 100)), 0, '', ',')  ?></strong>
                                                        <strong class="text-sm text-gray-500 opacity-80 line-through"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>
                                                    <?php } else { ?>
                                                        <strong class="font-semibold"><?php echo "đ " . number_format($sp["gia"], 0, '', ',')  ?></strong>

                                            <?php }
                                                }
                                            }


                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php }
                ?>

            <?php else : ?>
            <?php endif; ?>
        </div>
    </div>
</main>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/carousel.js"></script>
<?php
include_once("./includes/footer.php")
?>