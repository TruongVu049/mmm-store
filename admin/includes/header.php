<?php




include_once __DIR__ . "/../../classes/Session.php";
Session::checkAdmin();
if (isset($_GET['ac']) && $_GET['ac'] === 'dx') {
    Session::destroy();
    header("Location: index.php");
}
$path = explode('/', $_SERVER['REQUEST_URI']);
$len = (int)count($path);
if ('' === "sanpham.php" || false !== strpos($path[$len - 1], "sanpham.php")) {
    if ('' === "themsanpham.php" || false !== strpos($path[$len - 1], "themsanpham.php"))
        $title = "Thêm sản phẩm";
    else if ('' === "suasanpham.php" || false !== strpos($path[$len - 1], "suasanpham.php"))
        $title = "Sửa sản phẩm";
    else
        $title = "Sản phẩm";
} else if ($path[$len - 1] == "" || ('' === "index.php" || false !== strpos($path[$len - 1], "index.php")))
    $title = "Tổng quan";
else if ($path[$len - 1] == "" || ('' === "danhmuc.php" || false !== strpos($path[$len - 1], "danhmuc.php")))
    $title = "Danh mục";
else if ($path[$len - 1] == "" || ('' === "khuyenmai.php" || false !== strpos($path[$len - 1], "khuyenmai.php")))
    $title = "Khuyến mãi";
else if ($path[$len - 1] == "" || ('' === "donhang.php" || false !== strpos($path[$len - 1], "donhang.php")))
    $title = "Đơn hàng";
else if ('' === "khachhang.php" || false !== strpos($path[$len - 1], "khachhang.php"))
    $title = "Khách hàng";
?>

<!DOCTYPE html>

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../public/js/tailwindcss.bundle.js"></script>
    <link rel="shortcut icon" href="../public/images/favicon.png" type="image/x-icon" />
    <title><?php echo $title ?></title>
</head>


<body class="flex bg-gray-100 w-full overflow-x-hidden">
    <div id="modal-nav" class="hidden fixed inset-0 transition z-[200]">
        <div class="absolute inset-0 bg-[rgba(0,0,0,0.5)]">

        </div>
        <div class="relative h-full w-[60%] mr-auto z-[201] p-2 bg-white shadow-lg">
            <div id="btn-close-nav" class="float-right p-2  mb-2 text-lg cursor-pointer">
                <button id="btn_close-nav" data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col mx-4 mb-6 space-y-4  mt-10">
                <!-- <a class="@(Context.Request.Path == " /" ? "inline-flex items-center py-3 text-gray-200 bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" : "inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" )" ) href="@Url.Action(" Index", "Home" )">
                    <span class="ml-3">Tổng quan</span>
                </a> -->
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="#">
                    <span class="ml-3">Tổng quan</span>
                </a>
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="danhmuc.php">
                    <span class="ml-3">Danh mục</span>
                </a>
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="sanpham.php">
                    <span class="ml-3">Sản phẩm</span>
                </a>
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="khachhang.php">
                    <span class="ml-3">Khách hàng</span>
                </a>
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="xacnhandonhang">
                    <span class="ml-3">Chờ xác nhận</span>
                </a>
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="vanchuyendonhan">
                    <span class="ml-3">Đang vận chuyển</span>
                </a>
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="hoanthanhdonhang">
                    <span class="ml-3">Đã giao</span>
                </a>
                <a class="inline-flex items-center py-3 hover:text-gray-200 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="huydonhang">
                    <span class="ml-3">Đã hủy</span>
                </a>
            </nav>
        </div>
    </div>
    <aside class="hidden sm:flex sm:flex-col w-[20%] min-h-full ">
        <div class="flex-grow flex flex-col  text-gray-300 bg-gray-800">
            <div class="flex items-center justify-center h-20 w-full bg-purple-600 hover:bg-purple-500 focus:bg-purple-500">
                <a href="/" class="">
                    <svg class="h-12 w-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 16">
                        <path d="M0 .984v14.032a1 1 0 0 0 1.506.845l12.006-7.016a.974.974 0 0 0 0-1.69L1.506.139A1 1 0 0 0 0 .984Z" />
                    </svg>
                </a>
            </div>
            <nav class="flex flex-col mx-4 my-6 space-y-4">
                <!-- <a class="@(Context.Request.Path == " /" ? "inline-flex items-center py-3 text-gray-400 bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" : "inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" )" ) href="@Url.Action(" Index", "Home" )">
                    <span class="ml-3">Tỏng quan</span>
                </a> -->
                <a class="inline-flex items-center py-3 <?php if ($title == "Tổng quan") {
                                                            echo "text-gray-400 bg-gray-700";
                                                        } else {
                                                            echo "hover:text-gray-400 hover:bg-gray-700";
                                                        } ?> focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="./">
                    <span class="ml-3">Tỏng quan</span>
                </a>
                <div>
                    <button onclick="handleOpenDropdown('product_dropdown')" class="w-full text-left py-3 <?php if ($title == "Sản phẩm" || $title == "Thêm sản phẩm" || $title == "Sửa sản phẩm") {
                                                                                                                echo "text-gray-400 bg-gray-700";
                                                                                                            } else {
                                                                                                                echo "hover:text-gray-400 hover:bg-gray-700";
                                                                                                            } ?> focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                        <span class=" ml-3">Sản phẩm</span>
                        <div class="float-right">
                            <svg class="w-6 h-6 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M18.4 10.3A2 2 0 0 0 17 7H7a2 2 0 0 0-1.5 3.3l4.9 5.9a2 2 0 0 0 3 0l5-6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <ul id="product_dropdown" class="hidden">

                        <li class="ml-1">
                            <a href="danhmuc.php" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Danh mục</span>
                            </a>
                        </li>
                        <li class="ml-1">
                            <a href="sanpham.php" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Sản phẩm</span>
                            </a>
                        </li>
                        <li class="ml-1">
                            <a href="khuyenmai.php" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Khuyến mãi</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a class="inline-flex items-center py-3 <?php if ($title == "Khách hàng" || $title == "Sửa khách hàng" || $title == "Thêm khách hàng") {
                                                            echo "text-gray-400 bg-gray-700";
                                                        } else {
                                                            echo "hover:text-gray-400 hover:bg-gray-700";
                                                        } ?> focus:text-gray-400 focus:bg-gray-700 rounded-lg" href="khachhang.php">
                    <span class="ml-3">Khách hàng</span>

                </a>
                <div>
                    <!-- <button onclick="handleOpenOrderDropdown()" class="@(Context.Request.Path == " /order" ? "inline-flex w-full items-center py-3 text-gray-400 bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" : "w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg" )">
                        <span class="ml-3">Đơn hàng</span>
                    </button> -->
                    <button onclick="handleOpenDropdown('order_dropdown')" class="w-full text-left py-3 <?php if ($title == "Đơn hàng") {
                                                                                                            echo "text-gray-400 bg-gray-700";
                                                                                                        } else {
                                                                                                            echo "hover:text-gray-400 hover:bg-gray-700";
                                                                                                        } ?> focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                        <span class="ml-3">Đơn hàng</span>
                        <div class="float-right">
                            <svg class="w-6 h-6 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M18.4 10.3A2 2 0 0 0 17 7H7a2 2 0 0 0-1.5 3.3l4.9 5.9a2 2 0 0 0 3 0l5-6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <ul id="order_dropdown" class="hidden">
                        <!-- <li class="ml-1">
                            <a href="@Url.Action(" orderconfirm", "Order" )" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Chờ xác nhận</span>
                            </a>
                        </li> -->
                        <li class="ml-1">
                            <a href="xacnhandonhang.php" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Chờ xác nhận</span>
                            </a>
                        </li>
                        <li class="ml-1">
                            <a href="vanchuyendonhang.php" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Đang vận chuyển</span>
                            </a>
                        </li>
                        <li class="ml-1">
                            <a href="hoanthanhdonhang.php" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Đã giao</span>
                            </a>
                        </li>
                        <li class="ml-1">
                            <a href="huydonhang.php" class="w-full inline-flex items-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
                                <span class="ml-3">Đã hủy</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </aside>
    <div class="flex-grow text-gray-800 w-[80%]">
        <header class="flex items-center h-20 px-6 sm:px-10 bg-white">
            <button id="btn_open-nav" class="block sm:hidden relative flex-shrink-0 p-2 mr-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:bg-gray-100 focus:text-gray-800 rounded-full">
                <span class="sr-only">Menu</span>
                <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex flex-shrink-0 items-center ml-auto">
                <a target="_blank" href="../index.php" class="">
                    <button type="button" class="text-gray-900 border-2 border-purple-500 px-4 py-2 rounded-lg hover:bg-purple-500 hover:text-white hover:border-white sm:mr-4">
                        <span class="sm:block hidden">Chuyển đến trang chính</span>
                        <span class="sm:hidden block">Trang chính</span>
                    </button>
                </a>
                <button class="inline-flex items-center p-2 hover:bg-gray-100 focus:bg-gray-100 rounded-lg">
                    <span class="sr-only">User Menu</span>
                    <div class="hidden md:flex md:flex-col md:items-end md:leading-tight">
                        <span class="font-semibold"><?php echo Session::get('ten'); ?></span>
                    </div>
                    <span class="h-12 w-12 ml-2 sm:ml-3 mr-2 bg-gray-100 rounded-full overflow-hidden">
                        <svg class="h-full w-full object-cover  text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 11 14H9a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 10 19Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </span>
                </button>
                <div class="border-l pl-3 ml-3 space-x-1">
                    <a title="Đăng xuất" href="?ac=dx">
                        <button type="submit" class="relative p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600 rounded-full">
                            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
        </header>
        <!-- <main class="p-6 sm:p-10 space-y-6">
            main
        </main> -->


        <script>
            function handleOpenDropdown(elm_id) {
                const ul = document.getElementById(elm_id);
                ul.classList.contains("hidden") ? ul.classList.remove("hidden") : ul.classList.add("hidden");
            }
            document.getElementById('btn_open-nav').addEventListener("click", () => {
                document.getElementById('modal-nav').classList.remove("hidden");
            })

            document.getElementById('btn_close-nav').addEventListener("click", () => {
                document.getElementById('modal-nav').classList.add("hidden");
            })
        </script>