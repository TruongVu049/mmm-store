<?php
include_once "./helpers/view.php";
include_once("./classes/SanPham.php");
include_once("./classes/DanhMuc.php");

$dbsp = new SanPham();

if (isset($_GET['spid'])) {
    try {
        $sp = $dbsp->laySanPhamId($_GET['spid']);
        if ($sp) {
            $loaiSanPham = $dbsp->layLoaiSanPhamId($_GET['spid']);
        } else {
            header("Location: 404.php");
        }
    } catch (Exception $err) {
    }
} else {
    header("Location: 404.php");
}
view('header', ['title' => $sp['ten'], "decs" => $sp['ten'] . " - " . $sp['mota']]);

?>

<main>
    <section class="py-12 pt-4 sm:py-16 sm:pt-4">
        <div class="container mx-auto px-4">
            <nav class="flex">
                <ol role="list" class="flex items-center">
                    <li class="text-left">
                        <div class="-m-1"><a class="rounded-md p-1 text-sm font-medium text-gray-600 focus:text-gray-900 focus:shadow hover:text-gray-800" href="./"> Trang Chủ </a></div>
                    </li>
                    <li class="text-left">
                        <div class="flex items-center"><span class="mx-2 text-gray-400">/</span>
                            <div class="-m-1"><a class="rounded-md p-1 text-sm font-medium text-gray-600 focus:text-gray-900 focus:shadow hover:text-gray-800" href="sanpham.php"> Sản Phẩm </a></div>
                        </div>
                    </li>
                    <li class="text-left">
                        <div class="flex items-center"><span class="mx-2 text-gray-400">/</span>
                            <div class="-m-1"><a class="rounded-md p-1 text-sm font-medium text-gray-600 focus:text-gray-900 focus:shadow hover:text-gray-800" aria-current="page" href="#"><?php echo $sp['DanhMuc_ten'] ?></a></div>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="lg:col-gap-12 xl:col-gap-16 mt-8 grid grid-cols-1 gap-12 lg:mt-12 lg:grid-cols-5 lg:gap-16">
                <div class="lg:col-span-3 lg:row-end-1">
                    <div class="lg:flex lg:items-start">
                        <div class="lg:order-2 lg:ml-5">
                            <div class="max-w-xl overflow-hidden rounded-lg">
                                <img id="img_active" class="max-h-[420px] w-full max-w-full object-cover" src="<?php echo $sp['anhdaidien'] ?>">
                            </div>
                        </div>
                        <div class="mt-2 w-full lg:order-1 lg:w-32 lg:flex-shrink-0">
                            <div id="tab_gallery" class="flex flex-row items-start lg:flex-col lg:gap-0 gap-4">
                                <button type="button" class="border-green-500 border-4
                                flex-0 aspect-square mb-3 h-20 overflow-hidden rounded-lg border-2 border-[#dee2e6] border-solid text-center">
                                            <img src="<?php echo $sp['anhdaidien'] ?>" alt="img">
                                        </button>
                                <?php
                                $indexActive = 0;
                                foreach ($loaiSanPham as $lsp) { ?>
                                    <button type="button" class=" border-2 border-[#dee2e6]
                                    flex-0 aspect-square mb-3 h-20 overflow-hidden rounded-lg  border-solid text-center">
                                        <img data-lsphaid-<?php echo $lsp['id'] ?? "" ?> src="<?php echo $lsp['hinhanh'] ?>" alt="img">
                                    </button>
                                   <?php $indexActive++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2 lg:row-span-2 lg:row-end-2">
                    <h1 class="sm: text-2xl font-bold text-gray-900 sm:text-3xl"><?php echo $sp['ten'] ?></h1>
                    <div class="flex items-center mt-5">
                        <?php
                        $strStar = "";
                        for ($i = 1; $i <= 5; $i++) { //3.3
                            if (floatval($sp['sosaotb']) >= $i) {
                                $strStar .= '<svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>  ';
                            } else {
                                if (floatval($sp['sosaotb']) / 10 >= 0.5) {
                                    $strStar .= ' <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M13 4.024v-.005c0-.053.002-.353-.217-.632a1.013 1.013 0 0 0-1.176-.315c-.192.076-.315.193-.35.225-.052.05-.094.1-.122.134a4.358 4.358 0 0 0-.31.457c-.207.343-.484.84-.773 1.375a168.719 168.719 0 0 0-1.606 3.074h-.002l-4.599.367c-1.775.14-2.495 2.339-1.143 3.488L6.17 15.14l-1.06 4.406c-.412 1.72 1.472 3.078 2.992 2.157l3.94-2.388c.592-.359.958-.996.958-1.692v-13.6Zm-2.002 0v.025-.025Z" clip-rule="evenodd" />
                                    </svg>
                                    ';
                                } else {
                                    $strStar .= ' <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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
                    <div class="pt-2">
                        <span class=" text-rose-500 sm:text-3xl text-xl font-semibold">
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
                    <form id="form" action="thanhtoan.php" method="POST">
                        <input type="text" name="id" class="peer sr-only" value="<?php echo $sp['id'] ?? "" ?>">
                        <h2 class="mt-8 text-base text-gray-900">Màu sắc</h2>
                        <div class="mt-3 flex select-none flex-wrap items-center gap-1">
                            <?php
                            foreach ($loaiSanPham as $lsp) {
                            ?>

                                <label class="cursor-pointer">
                                    <input type="radio" name="color" class="peer sr-only" value="<?php echo $lsp['id'] ?? "" ?>">
                                    <p class="capitalize peer-checked:bg-gray-900 peer-checked:text-white rounded-lg border border-black px-6 py-2 font-bold"><?php echo $lsp['mausac'] ?></p>
                                </label>
                            <?php }
                            ?>
                            <div id="loading" role="status" class="ml-2 hidden">
                                <svg aria-hidden="true" class="w-10 h-10 text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="mt-2 errColor hidden  md:text-base text-sm text-red-500"></div>
                        <h2 class="mt-4 text-base text-gray-900">Size</h2>
                        <div id="container__size" class="mt-3 flex select-none flex-wrap items-center gap-1">

                        </div>
                        <button type="button" class="btn-open-modal-size group hover:text-green-500 mt-2 flex gap-x-3 items-center text-left text-sm font-medium text-gray-600">
                            <svg class="w-6 h-6 text-gray-800 group-hover:text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H7m2 3H7m2 3H7m4 2v2m3-2v2m3-2v2M4 5v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-9a1 1 0 0 1-1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1Z" />
                            </svg>
                            Bảng Quy Đổi Kích Cỡ
                            <svg class="w-6 h-6 text-gray-800 group-hover:text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                            </svg>
                        </button>
                        <div class="mt-2 errSize hidden  md:text-base text-sm text-red-500"></div>

                        <h2 class="mt-4 text-base text-gray-900">Số lượng</h2>

                        <div id="container__quantity" class="hidden mt-3 select-none flex items-center gap-4">
                            <label class="cursor-pointer md:w-[30%] sm:w-[40%] w-[50%] grid grid-cols-3  border-solid border border-secondColor">
                                <button type="button" id="btnDecrease" class="text-center  p-2 mx-auto text-lg font-semibold cursor-pointer">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="duration-200 hover:text-green-400" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 11h14v2H5z"></path>
                                    </svg>
                                </button>
                                <input type="text" name="quantity" class=" border-x border-secondColor text-center cursor-pointer font-bold outline-none" value="1">
                                <button type="button" id="btnIncrease" class="text-center p-2 mx-auto text-lg font-semibold cursor-pointer">
                                    <svg stroke=" currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="duration-200 hover:text-green-400" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                    </svg>
                                </button>
                            </label>
                            <span id="productAvail"></span>
                        </div>
                        <div class="mt-8"></div>
                        <div class=" flex gap-x-8 items-center  justify-between border-t border-b py-4 sm:flex-row sm:space-y-0">
                            <input type="text" class="peer sr-only" name="typeCheckout" value="1">
                            <?php if (Session::checkAuth()) : ?>
                                <button type="button" id="addCart" name="addCart" class="py-3  rounded-md bg-gray-900 text-white duration-200 font-semibold hover:bg-green-500 w-[50%]">Thêm vào giỏ hàng</button>
                                <button type="submit" name="btnSubmit" id="btnSubmit" class="py-3  rounded-md bg-gray-900 text-white duration-200 font-semibold hover:bg-green-500 w-[50%]  ">Mua ngay</button>
                            <?php else : ?>
                                <button type="button" class="btnLogin py-3  rounded-md bg-gray-900 text-white duration-200 font-semibold hover:bg-green-500 w-[50%]  ">Thêm vào giỏ hàng</button>
                                <button type="button" class="btnLogin py-3  rounded-md bg-gray-900 text-white duration-200 font-semibold hover:bg-green-500 w-[50%]  ">Mua ngay</button>
                            <?php endif; ?>
                        </div>

                    </form>
                    <ul class="mt-8 space-y-2">
                        <li class="flex gap-x-3 items-center text-left text-sm font-medium text-gray-600"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
                            </svg>Miễn phí vận chuyển</li>
                        <li class="flex gap-x-3 items-center text-left text-sm font-medium text-gray-600"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 20c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2h-2a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1H5c-1.103 0-2 .897-2 2v15zM5 5h2v2h10V5h2v15H5V5z"></path>
                                <path d="M14.292 10.295 12 12.587l-2.292-2.292-1.414 1.414 2.292 2.292-2.292 2.292 1.414 1.414L12 15.415l2.292 2.292 1.414-1.414-2.292-2.292 2.292-2.292z"></path>
                            </svg>Đổi trả bất cứ lúc nào</li>
                    </ul>
                </div>
                <div class="lg:col-span-3 product-ratings">
                    <h3 class="bg-gray-100 p-2 text-gray-900 md:text-md text-base font-semibold">MÔ TẢ SẢN PHẨM</h3>
                    <p class="text-base text-gray-700 pl-2 my-6"><?php echo $sp['mota'] ?></p>
                    <h3 class="bg-gray-100 p-2 text-gray-900 md:text-md text-base font-semibold ">ĐÁNH GIÁ SẢN PHẨM</h3>
                    <section class=" bg-white min-h-[440px]">
                        <div class="hidden product-ratings-loading animate-pulse">
                            <article class="p-6 text-base bg-white border-t border-gray-200 ">
                                <footer class="mb-2">
                                    <div class="flex items-start">
                                        <div class="mr-3 ">
                                            <div class="bg-gray-300 rounded-full  w-6 h-6 mr-2"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="h-2.5 bg-gray-300 rounded-full w-20 mb-2.5"></div>
                                            <div class="h-2.5 bg-gray-300 rounded-full w-32 mb-2.5"></div>
                                        </div>
                                    </div>
                                </footer>
                                <div class="h-4 mb-2 bg-gray-300 rounded-full  w-full"></div>
                                <div class="h-4 bg-gray-300 rounded-full  w-full"></div>
                            </article>
                            <article class="p-6 text-base bg-white border-t border-gray-200 ">
                                <footer class="mb-2">
                                    <div class="flex items-start">
                                        <div class="mr-3 ">
                                            <div class="bg-gray-300 rounded-full  w-6 h-6 mr-2"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="h-2.5 bg-gray-300 rounded-full w-20 mb-2.5"></div>
                                            <div class="h-2.5 bg-gray-300 rounded-full w-32 mb-2.5"></div>
                                        </div>
                                    </div>
                                </footer>
                                <div class="h-4 mb-2 bg-gray-300 rounded-full  w-full"></div>
                                <div class="h-4 bg-gray-300 rounded-full  w-full"></div>
                            </article>
                            <article class="p-6 text-base bg-white border-t border-gray-200 ">
                                <footer class="mb-2">
                                    <div class="flex items-start">
                                        <div class="mr-3 ">
                                            <div class="bg-gray-300 rounded-full  w-6 h-6 mr-2"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="h-2.5 bg-gray-300 rounded-full w-20 mb-2.5"></div>
                                            <div class="h-2.5 bg-gray-300 rounded-full w-32 mb-2.5"></div>
                                        </div>
                                    </div>
                                </footer>
                                <div class="h-4 mb-2 bg-gray-300 rounded-full  w-full"></div>
                                <div class="h-4 bg-gray-300 rounded-full  w-full"></div>
                            </article>
                        </div>
                        <div class=" product-ratings-comments-view">

                        </div>
                    </section>
                    <nav class="">
                        <ul class=" flex items-center justify-center -space-x-px h-10 text-base">
                            <li>
                                <a href="sanpham.php?p=0" class="pointer-events-none opacity-40  hover:text-white hover:bg-green-500 flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg ">
                                    <span class="sr-only">Previous</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"></path>
                                    </svg>
                                </a>
                            </li>
                            <ul class="product-ratings-pagination flex ">

                            </ul>
                            <li>
                                <a href="sanpham.php?p=2" class="pointer-events-none opacity-40 hover:text-white hover:bg-green-500 flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg ">
                                    <span class="sr-only">Next</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="mt-6">
                <h3 class=" p-2 text-gray-900 md:text-md text-base font-semibold ">
                    CÁC SẢN PHẨM LIÊN QUAN
                </h3>
                <?php
                $dssplq = $dbsp->laySanPham(0, 10, "", "", 0, 99999999, [$sp['DanhMuc_id']], null);
                $dssplq = $dssplq['sp'];
                $dssplq = array_filter($dssplq, function ($item) use ($sp) {
                    return $item['id'] !== $sp['id'];
                });
                ?>
                <div class="grid xl:grid-cols-5 lg:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-6 py-4">
                    <?php if (isset($dssplq) && count($dssplq) != 0) : ?>
                        <?php
                        foreach ($dssplq as $splq) { ?>
                            <div class="relative hover:border-[#00c16a] flex w-full  flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
                                <a href="chitietsanpham.php?spid=<?php echo $splq['id'] ?>" class="block h-full">
                                    <div class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-xl">
                                        <img class="object-cover w-[100%]" src="<?php echo $splq['hinhanh'] ?>" alt="product image" />
                                        <span class="<?php
                                                        if (is_null($splq['KhuyenMai_id'])) {
                                                            echo "hidden";
                                                        } else {
                                                            if (is_null($splq['thoigian_kt'])) {
                                                                echo "";
                                                            } else {
                                                                if (strtotime($splq['thoigian_kt']) > strtotime(date('Y-m-d'))) {
                                                                    echo "";
                                                                } else {
                                                                    echo "hidden";
                                                                }
                                                            }
                                                        }
                                                        ?> absolute top-0 left-0 m-2 rounded-full bg-rose-500  px-2 text-center text-sm font-medium text-white">Giảm <?php echo $splq['phantram'] ?>%</span>
                                    </div>
                                    <div class="mt-4 px-5 pb-5 h-[calc(100%-16rem)]">
                                        <div class="flex flex-col justify-between h-full">
                                            <h5 class="lg:text-lg md:text-base text-sm tracking-tight text-slate-900"><?php
                                                                                                                        if (strlen($splq['ten']) > 72) {
                                                                                                                            echo substr($splq['ten'], 0, 72) . "...";
                                                                                                                        } else {
                                                                                                                            echo $splq['ten'];
                                                                                                                        }
                                                                                                                        ?></h5>
                                            <div class="mb-4">
                                                <div class="mt-2 mb-2 flex items-center justify-between">

                                                    <div class="flex items-center">

                                                        <?php
                                                        $strStar = "";
                                                        for ($i = 1; $i <= 5; $i++) { //3.3
                                                            if (floatval($splq['sosaotb']) >= $i) {
                                                                $strStar .= '<svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                            <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                                                            </svg>  ';
                                                            } else {
                                                                if (floatval($splq['sosaotb']) / 10 >= 0.5) {
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
                                                        <span class="mr-2 ml-3  px-2.5 py-0.5 text-xs text-gray-500"><?php echo is_null($splq['luotban']) ? '' : 'Đã bán ' . $splq['luotban'] ?></span>
                                                    </div>
                                                </div>
                                                <span class="text-rose-500 md:text-xl text-lg">
                                                    <?php
                                                    if (is_null($splq['KhuyenMai_id'])) { ?>
                                                        <strong class="font-semibold"><?php echo "đ " . number_format($splq["gia"], 0, '', ',')  ?></strong>
                                                        <?php } else {
                                                        if (is_null($splq['thoigian_kt'])) { ?>
                                                            <strong class="font-semibold"><?php echo "đ " . number_format($splq["gia"] - ($splq["gia"] * ((float)$splq['phantram'] / 100)), 0, '', ',')  ?></strong>
                                                            <strong class="text-sm text-gray-500 opacity-80 line-through"><?php echo "đ " . number_format($splq["gia"], 0, '', ',')  ?></strong>
                                                            <?php } else {
                                                            if (strtotime($splq['thoigian_kt']) > strtotime(date('Y-m-d'))) { ?>
                                                                <strong class="font-semibold"><?php echo "đ " . number_format($splq["gia"] - ($splq["gia"] * ((float)$splq['phantram'] / 100)), 0, '', ',')  ?></strong>
                                                                <strong class="text-sm text-gray-500 opacity-80 line-through"><?php echo "đ " . number_format($splq["gia"], 0, '', ',')  ?></strong>
                                                            <?php } else { ?>
                                                                <strong class="font-semibold"><?php echo "đ " . number_format($splq["gia"], 0, '', ',')  ?></strong>

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
            <h1>

            </h1>
        </div>
    </section>

</main>

<div id="modal_nofi" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen ">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-lg shadow ">
                <div class="p-4 md:p-5 text-center">
                    <div class="modal__icon">

                    </div>
                    <!--  -->
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 modal__mes"></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-size" class="hidden fixed inset-0 transition z-[200]">
    <div class="absolute inset-0"></div>
    <div class="bg-gray-400 bg-opacity-50 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
        <div class="relative bg-white p-4 overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex items-center justify-between pb-4">
                <h3 class="md:text-lg text-md font-semibold text-gray-800">Hướng dẫn chọn size</h3>
                <svg class="btn-close-modal-size w-6 h-6 cursor-pointer text-gray-800 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            SIZE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Chiều cao (cm)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Cân nặng (kg)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-white  even:bg-gray-100  border-b sm:text-sm text-xs">
                        <td class="px-6 py-4">98 (2-3Y)</td>
                        <td class="px-6 py-4">95-101</td>
                        <td class="px-6 py-4">13-15</td>
                    </tr>
                    <tr class="odd:bg-white  even:bg-gray-100  border-b sm:text-sm text-xs">
                        <td class="px-6 py-4">100 (2-3Y)</td>
                        <td class="px-6 py-4">100</td>
                        <td class="px-6 py-4">14-17</td>
                    </tr>
                    <tr class="odd:bg-white  even:bg-gray-100  border-b sm:text-sm text-xs">
                        <td class="px-6 py-4">104 (3-4Y)</td>
                        <td class="px-6 py-4">101-107</td>
                        <td class="px-6 py-4">15-18</td>
                    </tr>
                    <tr class="odd:bg-white  even:bg-gray-100  border-b sm:text-sm text-xs">
                        <td class="px-6 py-4">110 (4-5Y)</td>
                        <td class="px-6 py-4">110</td>
                        <td class="px-6 py-4">18-23</td>
                    </tr>
                    <tr class="odd:bg-white  even:bg-gray-100  border-b sm:text-sm text-xs">
                        <td class="px-6 py-4">116 (6Y)</td>
                        <td class="px-6 py-4">113-119</td>
                        <td class="px-6 py-4">22-25</td>
                    </tr>
                    <tr class="odd:bg-white  even:bg-gray-100  border-b sm:text-sm text-xs">
                        <td class="px-6 py-4">120 (6-7Y)</td>
                        <td class="px-6 py-4">120</td>
                        <td class="px-6 py-4">24-29</td>
                    </tr>
                    <tr class="odd:bg-white  even:bg-gray-100  border-b sm:text-sm text-xs">
                        <td class="px-6 py-4">122 (7Y)</td>
                        <td class="px-6 py-4">119-125</td>
                        <td class="px-6 py-4">25-28</td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>
<script type="text/javascript" src="./public/js/productDetail.js"></script>
<script type="text/javascript" src="./public/js/tabGallery.js"></script>
<?php
include_once("./includes/footer.php")
?>