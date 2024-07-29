<?php
include "./helpers/view.php";
include_once("./classes/SanPham.php");
include_once("./classes/DanhMuc.php");
view('header', ['title' => 'Sản phẩm']);

$sp = new SanPham();
$dm = new DanhMuc();
$dsDM = $dm->layDanhMuc();
$ft_gioitinh = null;
$ft_danhmuc = null;
$gia_nn = null;
$gia_ln = null;
if (isset($_GET["gia_nn"]) || isset($_GET["gia_ln"])) {
    $gia_nn = $_GET["gia_nn"];
    $gia_ln = $_GET["gia_ln"];
}
if (isset($_GET["ft_gioitinh"]) || isset($_GET["ft_danhmuc"])) {
    $ft_gioitinh = $_GET["ft_gioitinh"] ?? null;
    $ft_danhmuc = $_GET["ft_danhmuc"] ?? null;
    $gia_nn = $_GET["gia_nn"];
    $gia_ln = $_GET["gia_ln"];
}
$p = 1;
$limit = 8;
$sapxep = "";
$timKiem = "";
if (isset($_GET['p'])) {
    $p = $_GET['p'];
}
if (isset($_GET['sx'])) {
    $sapxep = $_GET['sx'];
}
if (isset($_GET['s'])) {
    $timKiem = $_GET['s'];
}
$offset = ($p - 1) * $limit;
$lsp = $sp->laySanPham($offset, $limit, $timKiem, $sapxep, $gia_nn, $gia_ln, $ft_danhmuc, $ft_gioitinh);
$dsSP = $lsp['sp'];
$t = (int)$lsp['sl'];
$tongTrang = ceil($t / $limit);

?>
<style>
    input[type=range]::-webkit-slider-thumb {
        pointer-events: all;
        width: 24px;
        height: 24px;
        /* -webkit-appearance: none; */

        /* @apply w-6 h-6 appearance-none pointer-events-auto; */
    }
</style>
<main class="xl:container mx-auto lg:container sm:container">
    <div class="text-center pt-4">

        <?php if (isset($_GET['s'])) : ?>
            <h4 class="lg:text-xl md:text-lg text-base">Kết quả tiềm kiếm cho từ khóa '<strong class="text-red-500"><?php echo $_GET['s'] ?? $_GET['ss'] ?></strong>'</h4>
        <?php endif; ?>
    </div>
    <div class="gap-y-4 grid py-5 px-5">
        <div class="flex gap-4">
            <div class="rounded-lg bg-white shadow-md border border-gray-100 p-5 xl:flex-[1_1_25%] flex-[1_1_30%] md:block hidden">
                <h2 class="uppercase bg-white font-semibold text-xl">bộ lộc tìm kiếm</h2>
            </div>
            <div class="rounded-lg bg-white shadow-md border border-gray-100 p-5 xl:flex-[1_1_75%] flex-[1_1_70%]">
                <div class="flex justify-between items-center flex-wrap">
                    <div class="flex items-center">
                        <div id="btn-open-filter">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" class="md:hidden text-2xl duration-150 hover:text-[#00c16a] cursor-pointer" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"></path>
                            </svg>
                        </div>
                        <div id="tag-filter" class="flex items-center gap-2 px-2">
                            <!-- <span id="badge-dismiss-green" class="inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-green-800 bg-green-100 rounded dark:bg-green-900 dark:text-green-300">
                                Green
                                <button type="button" class="inline-flex items-center p-1 ms-2 text-sm text-green-400 bg-transparent rounded-sm hover:bg-green-200 hover:text-green-900 dark:hover:bg-green-800 dark:hover:text-green-300" data-dismiss-target="#badge-dismiss-green" aria-label="Remove">
                                    <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Remove badge</span>
                                </button>
                            </span> -->
                        </div>
                    </div>
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                        <?php if (isset($_GET['s'])) : ?>
                            <input class="sr-only" type="text" name="s" value="<?php echo $timKiem ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['ft_danhmuc'])) : ?>
                            <?php
                            foreach ($ft_danhmuc as $dm) { ?>
                                <input name="ft_danhmuc[]" checked value="<?php echo $dm ?>" class="sr-only" type="checkbox">
                            <?php }
                            ?>
                        <?php endif; ?>
                        <?php if (isset($_GET['ft_gioitinh'])) : ?>
                            <?php
                            foreach ($ft_gioitinh as $gt) { ?>
                                <input name="ft_gioitinh[]" checked value="<?php echo $gt ?>" class="sr-only" type="checkbox">
                            <?php }
                            ?>
                        <?php endif; ?>
                        <?php if (isset($_GET['gia_nn'])) : ?>
                            <input name="gia_nn" value="<?php echo $gia_nn ?>" class="sr-only">
                        <?php endif; ?>
                        <?php if (isset($_GET['gia_ln'])) : ?>
                            <input name="gia_ln" value="<?php echo $gia_ln ?>" class="sr-only">
                        <?php endif; ?>
                        <input class="sr-only" type="text" name="p" value="1">
                        <label class="text-[18px]">Sắp Xếp:
                            <select onchange="this.form.submit()" name="sx" class="border rounded border-gray-900 border-solid p-1">
                                <option <?php if ($sapxep == "") {
                                            echo "selected";
                                        } ?> value="">Mặc định</option>
                                <option <?php if ($sapxep == "gia_asc") {
                                            echo "selected";
                                        } ?> value="gia_asc">Giá tăng dần</option>
                                <option <?php if ($sapxep == "gia_desc") {
                                            echo "selected";
                                        } ?> value="gia_desc">Giá giảm dần</option>
                                <option <?php if ($sapxep == "ngaytao_desc") {
                                            echo "selected";
                                        } ?> value="ngaytao_desc">Sẳn phẩm mới</option>
                                <option <?php if ($sapxep == "ten_asc") {
                                            echo "selected";
                                        } ?> value="ten_asc">Theo tên</option>
                            </select>
                        </label>
                        <input type="submit" class="sr-only" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        <div class="flex gap-4 items-start">
            <div id="modal-filter" class="
                md:rounded-lg md:bg-white md:shadow-md md:p-5 xl:flex-[1_1_25%] md:flex-[1_1_30%] 
                md:block md:relative  fixed inset-0
                bottom-0 md:z-[10] z-[999999]
                hidden
                border border-gray-100
                ">
                <div id="filter-overlay" class="md:relative md:hidden block absolute w-full h-[100vh] inset-[0] opacity-60 bg-[#212121]"></div>
                <div class="
                    relative md:w-full sm:w-[50%] inset-0 w-[80%]  bg-white md:p-0 p-5 h-full
                    md:translate-x-[0]
                    md:shadow-none shadow-md ease-linear delay-0 duration-[300ms]
                
                    ">
                    <div class="md:hidden block pb-[40px]">
                        <div id="btn-close-filter" class="p-4 pt-0 float-right  cursor-pointer text-[20px] hover:text-[#00c16a] hover:duration-400">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512" class="" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                            </svg>
                        </div>
                    </div>
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                        <div>
                            <h3 class="text-gray-900 py-[10px] opacity-80 text-left text-xl font-semibold">Theo Danh Mục</h3>
                            <?php
                            if (count($dsDM) != 0) {
                                foreach ($dsDM as $i) {
                                    if (isset($ft_danhmuc) && in_array($i['id'],  $ft_danhmuc)) { ?>
                                        <div>
                                            <label for="tb_danhmuc" class="flex font-semibold flex-row-reverse items-center justify-end duration-200 hover:text-[#00c16a] cursor-pointer xl:w-[50%] lg:w-[60%] text-[18px]"><?php echo $i['ten'] ?>
                                                <input name="ft_danhmuc[]" checked value="<?php echo $i['id'] ?>" class="accent-[#00c16a] h-5 w-5 mr-3 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" type="checkbox">
                                            </label>
                                        </div>
                                    <?php } else { ?>
                                        <div>
                                            <label for="tb_danhmuc" class="flex font-semibold flex-row-reverse items-center justify-end duration-200 hover:text-[#00c16a] cursor-pointer xl:w-[50%] lg:w-[60%] text-[18px]"><?php echo $i['ten'] ?>
                                                <input name="ft_danhmuc[]" value="<?php echo $i['id'] ?>" class="accent-[#00c16a] h-5 w-5 mr-3 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" type="checkbox">
                                            </label>
                                        </div>
                            <?php }
                                }
                            }
                            ?>
                        </div>
                        <div>
                            <h3 class="text-gray-900 py-[10px] opacity-80 text-left text-xl font-semibold">Theo Giới Tính</h3>

                            <?php
                            $arr_gioitinh = ["nam", "nữ", "unisex"];
                            foreach ($arr_gioitinh as $i) {
                                if (isset($ft_gioitinh) && in_array($i,  $ft_gioitinh)) { ?>
                                    <div class="">
                                        <label for="<?php echo $i ?>" class="flex font-semibold flex-row-reverse items-center justify-end duration-200 hover:text-[#00c16a] cursor-pointer xl:w-[50%] lg:w-[60%] text-[18px] capitalize"><?php echo $i ?>
                                            <input checked class="accent-[#00c16a] h-5 w-5 mr-3 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" type="checkbox" name="ft_gioitinh[]" value="<?php echo $i ?>"></label>
                                    </div>
                                <?php } else { ?>
                                    <div class="">
                                        <label for="<?php echo $i ?>" class="flex font-semibold flex-row-reverse items-center justify-end duration-200 hover:text-[#00c16a] cursor-pointer xl:w-[50%] lg:w-[60%] text-[18px] capitalize"><?php echo $i ?>
                                            <input class="accent-[#00c16a] h-5 w-5 mr-3 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" type="checkbox" name="ft_gioitinh[]" value="<?php echo $i ?>"></label>
                                    </div>
                            <?php }
                            }
                            ?>
                        </div>
                        <?php if (isset($_GET['s'])) : ?>
                            <input class="sr-only" type="text" name="s" value="<?php echo $timKiem ?>">
                        <?php endif; ?>
                        <div>
                            <input class="sr-only" type="text" name="p" value="1">
                            <h3 class="text-gray-900 py-[10px] opacity-80 text-left text-xl font-semibold">Theo Giá</h3>
                            <div class="flex items-center mb-[10px] relative m-[10px_0_20px] bg-gray-900 rounded-lg">
                                <label for="gia_nn"></label>
                                <input id="ip_gia_nn" type="range" class="cursor-pointer absolute w-full h-[5px] top-0 pointer-events-none appearance-none bg-red-900 accent-red-900" name="gia_nn" min="0" max="2980000" step="1000" value="<?php echo $gia_nn ? $gia_nn : 0 ?>" />
                                <label for="gia_ln"></label>
                                <input id="ip_gia_ln" type="range" class="cursor-pointer absolute w-full h-[5px] top-0 pointer-events-none appearance-none bg-blue-900 accent-blue-900" name="gia_ln" min="40000" max="3000000" step="1000" value="<?php echo $gia_ln ? $gia_ln : 3000000 ?>" />
                            </div>
                            <div class="flex justify-between mt-[20px] font-semibold">
                                <span class="gia_nn"><?php echo $gia_nn ? $gia_nn : 0 ?></span>
                                <span class="gia_ln"><?php echo $gia_ln ? $gia_ln : 3000000 ?></span>
                            </div>
                        </div>
                        <div class="flex gap-4 mt-[20px] flex-wrap">
                            <button class="py-3 opacity-60 rounded-md bg-[#00c16a] text-white duration-200 font-semibold hover:bg-gray-900 lg:flex-1 flex-[1_1_100%]" type="reset">Làm mới</button>
                            <button class="py-3 rounded-md bg-[#00c16a] text-white duration-200 font-semibold hover:bg-green-400 lg:flex-1 flex-[1_1_100%]" type="submit">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="xl:flex-[1_1_75%] flex-[1_1_70%]">
                <div>
                    <?php if (count($dsSP) == 0) : ?>
                        <div class="h-full">
                            <div class="2xl:mt-0 lg:mt-[20px] md:mt-[120px] "><img class="w-[60%] mx-auto" src="./public/images/none-p.png" alt="error"></div>
                            <h3 class="uppercase opacity-70 sm:text-[24px] text-[16px] text-center">Không tìm thấy sản phẩm</h3>
                        </div>
                    <?php else : ?>
                        <div class="grid xl:grid-cols-4  lg:grid-cols-3 grid-cols-2 gap-4 relative">
                            <?php if (isset($dsSP) && count($dsSP) != 0) : ?>
                                <?php
                                foreach ($dsSP as $sp) { ?>
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
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <nav class="ml-auto">
            <ul class="flex items-center -space-x-px h-10 text-base">
                <?php
                $prevP = $p > 0 ? $p - 1 : 0;
                $nextP = $p >= $tongTrang ? $p : $p + 1;
                ?>
                <?php if ($p <= 1) : ?>
                    <li>
                        <a href="sanpham.php?p=<?php echo $prevP ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="pointer-events-none opacity-40  hover:text-white hover:bg-green-500 flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg ">
                            <span class="sr-only">Previous</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"></path>
                            </svg>
                        </a>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="sanpham.php?p=<?php echo $prevP ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="hover:text-white hover:bg-green-500 flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg ">
                            <span class="sr-only">Previous</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"></path>
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
                <ul class="sm:inline-flex hidden">

                    <?php
                    $i = 1;
                    while ($i <= $tongTrang) {
                        if ((int)$p >= 3) {
                            if ($i < 3) { ?>
                                <li>
                                    <a href="sanpham.php?p=<?php echo $i ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-green-500" : "text-gray-900 bg-white hover:text-white hover:bg-green-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
                                </li>
                                <?php $i++;
                            } else {
                                if ($i < (int)$p) {
                                    if (abs((int)$p - $i) <= 2) { ?>
                                        <li>
                                            <a href="sanpham.php?p=<?php echo $i ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-green-500" : "text-gray-900 bg-white hover:text-white hover:bg-green-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
                                        </li>
                                    <?php $i++;
                                    } else { ?>
                                        <li>
                                            <a href="#" class="pointer-events-none text-gray-900 bg-white flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 ">...</a>
                                        </li>
                                    <?php $i = abs((int)$p - 2);
                                    }
                                } else if ($i > (int)$p) {
                                    if (abs($i - (int)$p) <= 2) { ?>
                                        <li>
                                            <a href="sanpham.php?p=<?php echo $i ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-green-500" : "text-gray-900 bg-white hover:text-white hover:bg-green-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
                                        </li>
                                    <?php $i++;
                                    } else { ?>
                                        <li>
                                            <a href="#" class="pointer-events-none text-gray-900 bg-white flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 ">...</a>
                                        </li>
                                    <?php break;
                                    }
                                } else { ?>
                                    <li>
                                        <a href="sanpham.php?p=<?php echo $i ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-green-500" : "text-gray-900 bg-white hover:text-white hover:bg-green-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
                                    </li>
                                <?php $i++;
                                }
                            }
                        } else {
                            if ((int)$p + 5 == $i) { ?>
                                <li>
                                    <a href="#" class="pointer-events-none text-gray-900 bg-white flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 ">...</a>
                                </li>
                            <?php break;
                            } else { ?>
                                <li>
                                    <a href="sanpham.php?p=<?php echo $i ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-green-500" : "text-gray-900 bg-white hover:text-white hover:bg-green-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
                                </li>
                    <?php $i++;
                            }
                        }
                    }
                    ?>
                </ul>
                <?php if ($p >= $tongTrang) : ?>
                    <li>
                        <a href="sanpham.php?p=<?php echo $nextP ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="pointer-events-none opacity-40 hover:text-white hover:bg-green-500 flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg  ">
                            <span class="sr-only">Next</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                            </svg>
                        </a>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="sanpham.php?p=<?php echo $nextP ?><?php echo $timKiem ? "&s=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?><?php echo $ft_danhmuc ? "&" . http_build_query(array('ft_danhmuc' => $ft_danhmuc)) : "" ?><?php echo $ft_gioitinh ? "&" . http_build_query(array('ft_gioitinh' => $ft_gioitinh)) : "" ?><?php echo !is_null($gia_nn) ? "&gia_nn=$gia_nn" : "" ?><?php echo $gia_ln ? "&gia_ln=$gia_ln" : "" ?>" class="hover:text-white hover:bg-green-500 flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg ">
                            <span class="sr-only">Next</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</main>
<script type='text/javascript' src="<?php __DIR__ ?>public/js/filter.js"></script>
<?php
include_once("./includes/footer.php")
?>