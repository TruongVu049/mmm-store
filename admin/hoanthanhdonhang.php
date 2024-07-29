<?php
include_once("./includes/header.php");
include_once "../classes/DonHang.php";

$dh = new DonHang();
$sapxep = "";
if (isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p = 1;
}
if (isset($_GET['sx'])) {
    $sapxep = $_GET['sx'];
} else {
    $sapxep = "";
}
if (isset($_GET['tk'])) {
    $timKiem = $_GET['tk'];
} else {
    $timKiem = "";
}
$dsdh = $dh->layDonHang(3, $p, $sapxep, $timKiem);
$tongTrang = $dsdh['tongtrang'];


?>
<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Đơn hàng đã hoàn thành</h1>
        </div>
    </div>
    <div class="flex flex-col items-center space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="pt-2 relative  text-gray-600 sm:w-auto w-full">
            <div>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                    <div class="flex sm:items-center sm:justify-between sm:flex-row flex-col items-start gap-4">
                        <input onkeydown="(e)=>{if(e.keyCode == 13){this.form.submit()}}" class="submit_on_enter sm:w-auto  w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="text" name="tk" placeholder="Tìm kiếm ID đơn hàng..." value="<?php echo $timKiem ?>">
                        <div id="remove-all" class="sm:block hidden">
                            |
                        </div>
                        <div class="sm:w-auto w-full">
                            <label for="sort" class="sr-only mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                            <select onchange="this.form.submit()" name="sx" id="sort" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option <?php if ($sapxep == "") {
                                            echo "selected";
                                        } ?> value="">Sắp xếp đơn hàng</option>
                                <option <?php if ($sapxep == "tongtien_asc") {
                                            echo "selected";
                                        } ?> value="tongtien_asc">Tổng tiền tăng dần</option>
                                <option <?php if ($sapxep == "tongtien_desc") {
                                            echo "selected";
                                        } ?> value="tongtien_desc">Tổng tiền giảm dần</option>
                                <option <?php if ($sapxep == "ngaytao_asc") {
                                            echo "selected";
                                        } ?> value="ngaytao_asc">Ngày tăng dần</option>
                                <option <?php if ($sapxep == "ngaytao_desc") {
                                            echo "selected";
                                        } ?> value="ngaytao_desc">Ngày giảm dần</option>
                            </select>
                        </div>
                        <input type="submit" class="sr-only" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <div class="">
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-200">
            <thead class="text-xs text-gray-50 uppercase bg-gray-700 ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tên khách hàng
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ngày tạo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tổng tiền
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Địa chỉ
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Trạng thái
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Hành động
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                if (isset($dsdh)) { ?>
                    <?php
                    foreach ($dsdh['dshd'] as $item) { ?>
                        <tr class="bg-white border-b hover:bg-gray-50 ">
                            <td class="px-6 py-4 text-gray-900">
                                <span><?php echo $item["id"] ?></span>
                            </td>
                            <td class="px-6 py-4 text-gray-900 ">
                                <h4 class=" line-clamp-2"><?php echo $item["ten"] ?></h4>
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <span><?php echo $item["ngaytao"] ?></span>
                            </th>
                            <td class="px-6 py-4 text-gray-900">
                                <?php echo "đ " . number_format($item["tongtien"], 0, '', ',')  ?>
                            </td>
                            <td class="px-6 py-4 text-gray-900 ">
                                <span class=" line-clamp-2"><?php echo $item["diachi"] ?></span>
                            </td>
                            <td class="px-6 py-4 text-gray-900 w-full line-clamp-2">
                                <h6 class="line-clamp-2 text-purple-700   border border-purple-700 focus:outline-none rounded-lg text-sm px-2 py-1 text-center "><?php echo $item["trangthai"] ?></h6>
                            </td>

                            <td class="px-6 py-4 ">
                                <button data-order-detail="<?php echo $item['id'] ?>" type="button" class="text-gray-600 hover:text-white hover:bg-gray-600 border border-gray-600 focus:outline-none rounded-lg text-sm px-2 py-1 text-center ">Xem chi tiết</button>

                            </td>
                        </tr>
                    <?php  }  ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <br>
    <nav class="    ">
        <ul class="flex justify-end items-center -space-x-px h-10 text-base">
            <?php
            $prevP = $p > 0 ? $p - 1 : 0;
            $nextP = $p >= $tongTrang ? $p : $p + 1;
            ?>
            <?php if ($p <= 1) : ?>
                <li>
                    <a href="hoanthanhdonhang.php?p=<?php echo $prevP ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="pointer-events-none opacity-40  hover:text-white hover:bg-blue-500 flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg ">
                        <span class="sr-only">Previous</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"></path>
                        </svg>
                    </a>
                </li>
            <?php else : ?>
                <li>
                    <a href="hoanthanhdonhang.php?p=<?php echo $prevP ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="hover:text-white hover:bg-blue-500 flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg ">
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
                                <a href="hoanthanhdonhang.php?p=<?php echo $i ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-blue-500" : "text-gray-900 bg-white hover:text-white hover:bg-blue-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
                            </li>
                            <?php $i++;
                        } else {
                            if ($i < (int)$p) {
                                if (abs((int)$p - $i) <= 2) { ?>
                                    <li>
                                        <a href="hoanthanhdonhang.php?p=<?php echo $i ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-blue-500" : "text-gray-900 bg-white hover:text-white hover:bg-blue-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
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
                                        <a href="hoanthanhdonhang.php?p=<?php echo $i ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-blue-500" : "text-gray-900 bg-white hover:text-white hover:bg-blue-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
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
                                    <a href="hoanthanhdonhang.php?p=<?php echo $i ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-blue-500" : "text-gray-900 bg-white hover:text-white hover:bg-blue-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
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
                                <a href="hoanthanhdonhang.php?p=<?php echo $i ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="<?php echo (int)$p == $i ? "text-white bg-blue-500" : "text-gray-900 bg-white hover:text-white hover:bg-blue-500" ?> flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 "><?php echo $i ?></a>
                            </li>
                <?php $i++;
                        }
                    }
                }
                ?>
            </ul>
            <?php if ($p >= $tongTrang) : ?>
                <li>
                    <a href="hoanthanhdonhang.php?p=<?php echo $nextP ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="pointer-events-none opacity-40 hover:text-white hover:bg-blue-500 flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg  ">
                        <span class="sr-only">Next</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                        </svg>
                    </a>
                </li>
            <?php else : ?>
                <li>
                    <a href="hoanthanhdonhang.php?p=<?php echo $nextP ?><?php echo $timKiem ? "&tk=$timKiem" : "" ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="hover:text-white hover:bg-blue-500 flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg ">
                        <span class="sr-only">Next</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                        </svg>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</main>


<div id="modal-order-detail" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen ">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                <div class="p-4 sm:p-6 space-y-6">
                    <div class="order-detail-content">

                    </div>
                    <div class="order-loading animate-pulse hidden">
                        <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between items-center">
                            <div class="mr-6">
                                <div class="h-4 bg-gray-300 rounded-full w-32 mb-2"></div>
                                <div class="h-4 bg-gray-300 rounded-full w-48    "></div>
                            </div>
                            <div class="h-2.5 bg-gray-300 rounded-full w-20 "></div>
                        </div>
                        <div class="flex flex-col gap-5 mt-4">
                            <div class="h-[444px] overflow-y-auto">
                                <div class="bg-white p-4 shadow-lg false">
                                    <div class="flex items-center justify-between ">
                                        <div class="h-3 bg-gray-300 rounded-full w-20 mb-2"></div>
                                    </div>
                                    <div class="clear-both gap-1 flex justify-between py-2 items-center border-y border-gray-200 border-solid">
                                        <div class="flex items-center gap-1">
                                            <div class="h-20 w-20 bg-gray-300 rounded-full"></div>
                                            <div>
                                                <div class="h-4 bg-gray-300 rounded-full w-32  mb-2 "></div>
                                                <div class="h-4 bg-gray-300 rounded-full w-40 mb-2"></div>
                                                <div class="h-4 bg-gray-300 rounded-full w-60 "></div>
                                            </div>
                                        </div>
                                        <div class="h-2.5 bg-gray-300 rounded-full w-20 "></div>
                                    </div>
                                    <div class="flex justify-end flex-col items-end">
                                        <div class="pt-4 pb-4 h-2.5 bg-gray-300 rounded-full w-20 "></div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
                                <div class="bg-white p-4 shadow-lg false">
                                    <div class="flex items-center justify-between ">
                                        <div class="h-3 bg-gray-300 rounded-full w-20 mb-2"></div>
                                    </div>
                                    <div class="clear-both gap-1 flex justify-between py-2 items-center border-y border-gray-200 border-solid">
                                        <div class="flex items-center gap-1">
                                            <div class="h-20 w-20 bg-gray-300 rounded-full"></div>
                                            <div>
                                                <div class="h-4 bg-gray-300 rounded-full w-32  mb-2 "></div>
                                                <div class="h-4 bg-gray-300 rounded-full w-40 mb-2"></div>
                                                <div class="h-4 bg-gray-300 rounded-full w-60 "></div>
                                            </div>
                                        </div>
                                        <div class="h-2.5 bg-gray-300 rounded-full w-20 "></div>
                                    </div>
                                    <div class="flex justify-end flex-col items-end">
                                        <div class="pt-4 pb-4 h-2.5 bg-gray-300 rounded-full w-20 "></div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn-close-order-detail absolute top-0 right-0 p-4">
                    <svg class="w-6 h-6 text-gray-900 hover:text-gray-700 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="./js/order.js"></script>
<?php
include_once("./includes/footer.php")
?>