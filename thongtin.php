<?php
include "./helpers/view.php";
include "./classes/KhachHang.php";
view('header', ['title' => 'Thông tin tài khoản']);
if (!Session::checkAuth()) {
    echo "<script>location.href = 'dangnhap.php'</script>";
}

$kh = new KhachHang();

$thongTinKh = $kh->layThongTin(Session::get("cusId"));
// Array
// (
//     [kh] => Array
//         (
//             [id] => 18
//             [email] => nguyenvu492003@gmail.com
//             [ten] => Trường Vũ
//             [sdt] => 0123123213
//         )
//     [dc] => Array
//         (
//             [0] => Array
//                 (
//                     [id] => 1
//                     [sdt] => 032324234
//                     [diachi] => TPHCM, Q4
//                     [diachicuthe] => 123 dvf, cdc
//                     [macdinh] => 1
//                 )
//         )
// )
?>
<main class="container mx-auto px-4 mt-12 ">
    <?php if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['typeCheckout'])) : ?>
        <form action="thanhtoan.php" method="POST" class="flex justify-end mb-4">
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
            <button class="py-2 px-4 bg-blue-600 rounded-md text-white hover:bg-blue-500">Trở lại thanh toán</button>
        </form>
    <?php endif; ?>
    <div class="bg-white overflow-hidden shadow rounded-lg border">

        <div class="flex items-center justify-between px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Thông tin người dùng</h3>
            <a href="doimatkhau.php" class="cursor-pointer flex gap-2 text-sm border-green-400 border-2 rounded-lg px-4 py-2 items-center group hover:text-green-400">Đổi mật khẩu</a>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
                    <dt class="text-sm font-medium text-gray-800">Họ tên</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class=""><label for="fullName" class="block text-sm font-medium leading-6 text-gray-900"></label>
                            <div class="mt-2">
                                <!-- <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 ">
                                    <input type="text" name="fullName" id="fullName" autocomplete="fullName" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo $thongTinKh['kh']['ten'] ?? "" ?>">
                                </div> -->
                                <span class="md:text-base text-sm text-gray-900"><?php echo $thongTinKh['kh']['ten'] ?? "" ?></span>
                            </div>
                        </div>
                    </dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
                    <dt class="text-sm font-medium text-gray-800">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900"></label>
                            <div class="mt-2">
                                <span class="md:text-base text-sm text-gray-900"><?php echo $thongTinKh['kh']['email'] ?? "" ?></span>
                            </div>
                        </div>
                    </dd>
                </div>
                <!-- <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
                    <dt class="text-sm font-medium text-gray-800">Số điện thoại</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="">
                            <label for="phoneNumber" class="block text-sm font-medium leading-6 text-gray-900"></label>
                            <div class="mt-2">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 ">
                                    <input type="text" name="phone" id="phone" autocomplete="phone" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo $thongTinKh['kh']['sdt'] ?? "" ?>">
                                </div>
                            </div>
                        </div>
                    </dd>
                </div> -->
                <div class="py-3 sm:py-5 flex items-center justify-between sm:px-6">
                    <dt class="text-sm font-medium text-gray-800">Địa chỉ</dt>
                    <button id="btn-open-modalAd" class="flex gap-2 text-sm border-green-400 border-2 rounded-lg px-4 py-2 items-center group hover:text-green-400">
                        <svg class="group-hover:text-green-400 w-4 h-4 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                        </svg>
                        Thêm địa chỉ
                    </button>
                </div>
                <div class="listAddress divide-y divide-gray-300 my-3">
                    <!-- render -->
                </div>
            </dl>
        </div>
    </div>
    <!-- <button type="button" class="mt-4 w-full bg-green-500 font-semibold text-base py-3 rounded-lg duration-200 hover:bg-green-400 text-white px-5">Lưu</button> -->
</main>

<div id="modal-address" class="hidden inset-0 transition z-[200]">
    <div class="absolute inset-0"></div>
    <div id="container__search" class="bg-gray-600 bg-opacity-40 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
        <div class="container mx-auto">
            <form id="formAd" method="POST" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                <input type="text" id="userId" name="userId" class="peer sr-only" value="<?php echo $thongTinKh['kh']['id'] ?? "" ?>" />
                <div class="mb-3">
                    <label for="addPhone" class="block mb-2 text-sm font-medium text-gray-900 ">Số điện thoại nhận hàng</label>
                    <input type="text" id="addPhone" name="addPhone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  " required />
                    <span class="errAddPhone hidden md:text-base text-sm text-red-500"></span>
                </div>
                <div class="mb-3">
                    <label for="province" class="block mb-2 text-sm font-medium text-gray-900 ">Tỉnh/Thành</label>
                    <select name="province" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 ">
                        <option selected value="">Chọn tỉnh/thành</option>
                    </select>
                    <span class="errProvince hidden md:text-base text-sm text-red-500"></span>
                </div>
                <div class="mb-3">
                    <label for="district" class="block mb-2 text-sm font-medium text-gray-900 ">Quận/Huyện</label>
                    <select name="district" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 ">
                        <option selected value="">Chọn quận/huyện</option>
                    </select>
                    <span class="errDistrict hidden md:text-base text-sm text-red-500"></span>

                </div>
                <div class="mb-3">
                    <label for="commune" class="block mb-2 text-sm font-medium text-gray-900 ">Phường/Xã</label>
                    <select name="commune" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 ">
                        <option selected value="">Chọn phường/xã</option>
                    </select>
                    <span class="errCommune hidden md:text-base text-sm text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label for="addressDetails" class="block mb-2 text-sm font-medium text-gray-900 ">Địa chỉ cụ thể</label>
                    <textarea required id="addressDetails" name="addressDetails" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 "></textarea>
                    <span class="errAddressDetails hidden md:text-base text-sm text-red-500"></span>
                </div>
                <div class="mb-3">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="macdinh" value="1" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all  peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 ">Đặt làm địa chỉ mặc định</span>
                    </label>
                </div>
                <span class="errModal hidden md:text-base text-sm text-red-500"></span>
                <div class="flex items-center gap-3 justify-end">
                    <button id="btn-close-modalAd" type="button" class="text-gray-800  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Trở lại</button>
                    <button id="btn-add-modalAd" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Lưu</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript" src="<?php __DIR__ ?>public/js/navbar.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/cart.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/user.js"></script>
<!-- <script>
    new Promise((resolve, reject) => {
        resolve();
    }).then((res) => {
        const elm = document.createElement('script');
        elm.setAttribute("type", 'text/javascript');
        elm.setAttribute("src", 'public/js/cart.js');
        document.body.appendChild(elm);
    }).then(res => {
        const elm = document.createElement('script');
        elm.setAttribute("type", 'text/javascript');
        elm.setAttribute("src", 'public/js/user.js');
        document.body.appendChild(elm);
    });
</script> -->