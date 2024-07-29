<?php
include_once "./classes/Session.php";
Session::init();
$path = explode('/', $_SERVER['REQUEST_URI']);
$len = (int)count($path);

if (Session::checkAuth() === true && Session::exp() === true) {
    Session::destroy();
    header("Location:index.php");
}

if (isset($_GET['logout']) && $_GET['logout'] == true) {
    Session::destroy();
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./public/js/tailwindcss.bundle.js"></script>
    <link rel="shortcut icon" href="./public/images/favicon.png" type="image/x-icon" />
    <meta name="description" content="">
    <title><?= $title ?? 'Home' ?></title>
    <meta name="description" content="<?= $decs ?? 'Thoi trang tre em' ?>">
</head>

<body>
    <input type="text" name="checkLogin" id="checkLogin" class="hidden peer sr-only" value="<?php echo Session::checkAuth() ? Session::get("cusId") : "" ?>">
    <nav class="sticky top-0 z-[9999] block w-full max-w-full px-4 py-2 text-white bg-white border rounded-none shadow-md h-max border-white/80 bg-opacity-80 backdrop-blur-2xl backdrop-saturate-200 lg:px-8 lg:py-4">
        <div class="flex items-center justify-between text-gray-900">
            <a href="./" class="mr-4 block cursor-pointer py-1.5 font-sans text-base font-medium leading-relaxed text-inherit antialiased">
                MMM
            </a>
            <div class="flex items-center gap-4">
                <div class="hidden mr-4 lg:block">
                    <ul class="flex flex-col gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-6">
                        <li class="group block p-1 font-sans text-sm antialiased font-normal leading-normal text-gray-900">
                            <?php if ($path[$len - 1] == "" || ('' === "index.php" || false !== strpos($path[$len - 1], "index.php"))) : ?>
                                <a href="./" class=" text-[#00c16a] flex items-center">
                                    Trang chủ
                                </a>
                            <?php else : ?>
                                <a href="./" class="group-hover:text-[#00c16a] flex items-center">
                                    Trang chủ
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="group block p-1 font-sans text-sm antialiased font-normal leading-normal text-gray-900">
                            <?php if ('' === "sanpham.php" || false !== strpos($path[$len - 1], "sanpham.php")) : ?>
                                <a href="sanpham.php" class=" text-[#00c16a] flex items-center">
                                    Sản Phẩm
                                </a>
                            <?php else : ?>
                                <a href="sanpham.php" class="group-hover:text-[#00c16a] flex items-center">
                                    Sản Phẩm
                                </a>
                            <?php endif; ?>

                        </li>
                        <li class="group block p-1 font-sans text-sm antialiased font-normal leading-normal text-gray-900">
                            <?php if ($path[$len - 1] == "lienhe.php") : ?>
                                <a href="lienhe.php" class="text-[#00c16a] flex items-center">
                                    Liên hệ
                                </a>
                            <?php else : ?>
                                <a href="lienhe.php" class="group-hover:text-[#00c16a] flex items-center">
                                    Liên hệ
                                </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>

                <div class="flex gap-1 ml-auto md:mr-4">
                    <button data-button-openSearch class=" relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-white transition-all hover:bg-white/10 active:bg-white/30 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                        <span class="group absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                            <svg class="group-hover:text-[#00c16a] w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </span>
                    </button>
                    <?php if (Session::checkAuth()) : ?>
                        <button data-button-change="true" data-button-openCart class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-white transition-all hover:bg-white/10 active:bg-white/30 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                            <span class="group absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                <svg class="relative group-hover:text-[#00c16a] w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.3L19 7H7.3" />
                                </svg>
                            </span>
                            <span class="cart-drawer__view absolute -top-1 -right-1 bg-rose-500 rounded-lg p-1 md:text-sm text-xs"></span>
                        </button>
                        <div class="relative group ">
              <div class="flex items-center gap-2 ">
                  <button data-button-openSearch class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-white transition-all disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                      <span class=" absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                          <svg class="group-hover:text-[#00c16a] w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a9 9 0 0 0 5-1.5 4 4 0 0 0-4-3.5h-2a4 4 0 0 0-4 3.5 9 9 0 0 0 5 1.5Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          </svg>
                      </span>
                  </button>
                  <span class="group-hover:text-[#00c16a] cursor-pointer"><?php
                                                                                        $name = Session::get("cusName");
                                                                                        if (strlen($name) > 20) {
                                                                                            echo substr($name, 0, 20) . "...";
                                                                                        } else {
                                                                                            echo $name;
                                                                                        }
                                                                                        ?></span>
              </div>
              <div class="absolute min-w-[130px] top-[100%] left-0 bg-[#e2e8f0] shadow-xl rounded-md z-[9990] hidden group-hover:block">
                  <ul class="relative ">
                  <li class="p-4 pl-1 flex items-center">
                                        <a class="md:text-base text-sm hover:text-[#00c16a]" href="thongtin.php">Thông tin </a>
                                    </li>
                                    <li class="p-4 pl-1 flex items-center">
                                        <a class="md:text-base text-sm hover:text-[#00c16a]" href="donhang.php">Đơn hàng</a>
                                    </li>
                                    <li class="p-4 pl-1">
                                        <a class="md:text-base text-sm hover:text-[#00c16a]" href="index.php?logout=true">Đăng xuất</a>
                                    </li>
                  </ul>
              </div>
          </div>
                    <?php else : ?>

                        <a href="dangnhap.php">
                        <button
                            class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-white transition-all hover:bg-white/10 active:bg-white/30 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button"
                        >
                            <span
                            class="group absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            >
                            <svg
                                class="relative group-hover:text-[#00c16a] w-6 h-6 text-gray-800"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.3L19 7H7.3"
                                />
                            </svg>
                            </span>
                        </button>
                        </a>
                        <a class=" sm:block hidden text-gray-900" href="dangnhap.php"> | 
                        <button class="py-2 px-4 border-none text-gray-900 hover:text-green-500">Đăng nhập</button>
                        </a>
                        <a class="sm:block hidden" href="dangky.php">
                        <button class="py-2 px-4 rounded-md border-green-500 text-white bg-green-500 hover:bg-green-400">Đăng ký</button>
                        </a>
                    <?php endif; ?>
                </div>
                <button data-button-open class="relative ml-auto h-6 max-h-[40px] w-6 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-inherit transition-all hover:bg-transparent focus:bg-transparent active:bg-transparent disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:hidden" type="button">
                    <span class="group absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:text-[#00c16a] w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </nav>

    <div id="navbar-mb" class="z-[99999] fixed top-0 right-0 h-[100vh] w-full  duration-300 delay-0 ease-linear opacity-100 invisible">
        <div id="navbar-overlay" class=" absolute w-full h-[100vh] inset-[0] opacity-60 bg-[#212121] "></div>
        <div class="
        w-[350px] h-full bg-white relative 
        ease-in-out delay-0 duration-200 ml-auto p-[20px] text-center flex flex-col overflow-auto
          shadow-[-1px_0px_20px_-5px_#aaa]
          translate-x-[100%]
          
          ">
            <div class="pb-[28px]">
                <div id="btn-close-nav" class=" p-4 z-[10] float-right cursor-pointer text-[20px]  hover:text-[#00c16a]">
                    <svg id="svg" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512" class="btn-close-nav" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-left font-semibold capitalize m-[-20px]">
                <ul class=" clear-both">
                    <li><a aria-current="page" class="block p-[20px] hover:text-[#00c16a] border-t-2 border-solid border-[#eeeeee] duration-300" href="/">Trang Chủ</a></li>
                    <li><a class="block p-[20px] hover:text-[#00c16a] border-t-2 border-solid border-[#eeeeee] duration-300" href="sanpham.php">Sản Phẩm</a></li>
                    <li><a class="block p-[20px] hover:text-[#00c16a] border-t-2 border-solid border-[#eeeeee] duration-300" href="lienhe.php">Liên Hệ</a></li>
                
                    <?php if (Session::checkAuth()) : ?>
                        <li>
                        <a
                            class="block p-[20px] hover:text-[#00c16a] border-t-2 border-solid border-[#eeeeee] duration-300"
                            href="thongtin.php"
                            >Thông tin người dùng</a
                        >
                        </li>
                        <li >
                        <a
                        class="block p-[20px] hover:text-[#00c16a] border-t-2 border-solid border-[#eeeeee] duration-300"
                            href="index.php?logout=true"
                            >Đăng xuất</a
                        >
                        </li>
                    <?php else : ?>

                        <li class="sm:hidden block">
                        <a
                            class="block p-[20px] hover:text-[#00c16a] border-t-2 border-solid border-[#eeeeee] duration-300"
                            href="dangnhap.php"
                            >Đăng nhập</a
                        >
                        </li>
                        <li class="sm:hidden block">
                        <a
                            class="block p-[20px] hover:text-[#00c16a] border-t-2 border-solid border-[#eeeeee] duration-300"
                            href="dangky.php"
                            >Đăng ký</a
                        >
                        </li>
                        
                    <?php endif; ?>
                
                </ul>
            </div>
        </div>
    </div>

    <div id="cart" class="z-[99999] fixed top-0 right-0 h-[100vh] w-full  duration-300 delay-0 ease-linear opacity-100 invisible">
        <div class="absolute w-full h-[100vh] inset-[0] opacity-60 bg-[#212121] "></div>
        <div class="
          xl:w-[30%] sm:w-[50%] w-[90%] h-full bg-white relative
          ease-linear delay-0 duration-[250ms] ml-auto p-[20px] text-center flex flex-col overflow-auto

          shadow-[-1px_0px_20px_-5px_#aaa]

          translate-x-[100%]
          ">
            <div><svg data-button-closeCart stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512" class="float-right m-2 cursor-pointer text-[20px] hover:text-green-400 hover:duration-400" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                </svg></div>
            <div class="flex flex-col h-full  text-left font-semibold capitalize overflow-y-auto">
                <h3 class="font-[600] text-[22px] text-gray-800">Giỏ Hàng <span class="text-gray-400 sm:text-base text-sm font-normal">(Sản phẩm đã thêm gần đây)</span></h3>
                <div class="mt-8 clear-both">
                    <div class="flow-root">
                        <!-- animate-pulse -->
                        <!-- <div class="flex py-6 justify-between">
                            <div class="flex items-start gap-4  ">
                                <div class="h-24 w-24 bg-gray-300 rounded-md">
                                </div>
                                <div>
                                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-32 mb-2.5"></div>
                                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-40 mb-2.5"></div>
                                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-48 mb-2.5"></div>
                                </div>
                            </div>
                            <div>
                                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
                            </div>
                        </div> -->
                        <ul role="list" class="cart-drawer__container -my-6 divide-y divide-gray-300 ">
                            <!-- <li class="flex py-6">
                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                    <img src="https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-01.jpg" alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt." class="h-full w-full object-cover object-center">
                                </div>
                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900 gap-4">
                                            <h3 class="line-clamp-2">
                                                <a href="#">Throwbackádf ádf ád fasd fasd á fdas ád sd f Hip Bag ád ád á fasd fasdfads fads fa ads ads ád fasdf sad sd fa sdf</a>
                                            </h3>
                                            <p class="ml-4">$90.00</p>
                                        </div>
                                        <p class="text-gray-500">X 1</p>
                                    </div>
                                </div>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <div><a href="giohang.php"><button class="bg-gray-800 py-3 w-full text-white mt-4 duration-300 hover:bg-green-500 hover:text-white">Xem Giỏ Hàng</button></a></div>
        </div>
    </div>

    <div id="modal-search" class="hidden fixed inset-0 transition z-[200]">
        <div class="absolute inset-0"></div>
        <div id="container__search" class="bg-white bg-opacity-50 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
            <div class="z-[9999] top-[92px] left-0 right-0 fixed z-50">
                <div class="container mx-auto">
                    <form id="form-search" action="sanpham.php" method="get">
                        <div class=" relative border-2 border-green-400 flex p-3 rounded-[5px] sm:mx-[40px] mx-[20px] shadow-2xl flex items-center gap-x-[10px] content-stretch bg-white  ">
                            <div class="w-[90%]">
                                <label for="s">
                                    <input name="s" class="w-full border-[#dee2e6] border-[1px] border-solid p-[5.5px] 
                  " placeholder="Tìm kiếm sản phẩm ..." value="">
                                </label>
                            </div>
                            <div class="w-[10%]">
                                <button class="block w-full text-center h-full bg-gray-900 content-stretch  rounded-[6px] duration-300 hover:bg-gray-800  cursor-pointer p-[10px]" type="submit">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="text-white mx-auto" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-spinner" class="hidden fixed inset-0 transition z-[200]">
        <div class="absolute inset-0"></div>
        <div class="bg-white bg-opacity-50 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
            <div class="flex gap-2">
                <div class="w-5 h-5 rounded-full animate-pulse bg-rose-500"></div>
                <div class="w-5 h-5 rounded-full animate-pulse bg-rose-500"></div>
                <div class="w-5 h-5 rounded-full animate-pulse bg-rose-500"></div>
            </div>
        </div>
    </div>