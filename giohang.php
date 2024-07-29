<?php
include "./helpers/view.php";
view('header', ['title' => 'Giỏ hàng']);
if (!Session::checkAuth()) {
    echo "<script>location.href = 'dangnhap.php'</script>";
}



?>

<div class="bg-gray-100">
    <main class="xl:container mx-auto lg:container sm:container  ">
        <form id="form_shoppingcart" action="thanhtoan.php" method="POST">
            <div class="md:h-[900px] h-[600px] container-shoppingcart w-full bg-white md:p-10 p-4  lg:border-r border-gray-200 overflow-y-auto shadow-xl">
                <div class="flex justify-between border-b pb-8">
                    <h1 class="font-semibold text-2xl">Giỏ hàng</h1>
                </div>
                <div class="flex mt-10 mb-5">
                    <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Sản phẩm</h3>
                    <h3 class="font-semibold  text-gray-600 text-xs uppercase w-1/5 ">Số lượng</h3>
                    <h3 class="font-semibold  text-gray-600 text-xs uppercase w-1/5 ">Giá</h3>
                    <h3 class="font-semibold  text-gray-600 text-xs uppercase w-1/5 ">Tổng</h3>
                    <h3 class="font-semibold  text-gray-600 text-xs uppercase  "></h3>
                </div>
                <div class="container-content">
                </div>
                <div class="loader hidden">
                    <div class="flex items-center justify-between hover:bg-gray-100 -mx-8 px-6 py-5">
                        <div class="flex w-[60%]">
                            <div class="ml-8 h-24 w-24 bg-gray-300 rounded-md"></div>
                            <div class="flex flex-col justify-between ml-4 flex-grow">
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[70%] mb-2.5"></div>
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[80%] mb-2.5"></div>
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[90%] mb-2.5"></div>
                            </div>
                        </div>
                        <div class="h-2.5 bg-gray-300 rounded-full  w-32 mb-2.5"></div>
                    </div>
                    <div class="flex items-center justify-between hover:bg-gray-100 -mx-8 px-6 py-5">
                        <div class="flex w-[60%]">
                            <div class="ml-8 h-24 w-24 bg-gray-300 rounded-md"></div>
                            <div class="flex flex-col justify-between ml-4 flex-grow">
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[70%] mb-2.5"></div>
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[80%] mb-2.5"></div>
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[90%] mb-2.5"></div>
                            </div>
                        </div>
                        <div class="h-2.5 bg-gray-300 rounded-full  w-32 mb-2.5"></div>
                    </div>
                    <div class="flex items-center justify-between hover:bg-gray-100 -mx-8 px-6 py-5">
                        <div class="flex w-[60%]">
                            <div class="ml-8 h-24 w-24 bg-gray-300 rounded-md"></div>
                            <div class="flex flex-col justify-between ml-4 flex-grow">
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[70%] mb-2.5"></div>
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[80%] mb-2.5"></div>
                                <div class="h-2.5 bg-gray-300 rounded-full  w-[90%] mb-2.5"></div>
                            </div>
                        </div>
                        <div class="h-2.5 bg-gray-300 rounded-full  w-32 mb-2.5"></div>
                    </div>
                </div>


            </div>
            <div class="sticky bottom-0  bg-white z-[999] shadow-lg">
                <h1 class="font-semibold text-2xl border-b pb-8 bg-gray-300"></h1>
                <div class="w-full lg:px-6 sm:px-4 px-3 lg:py-8 sm:py-4 py-2">
                    <div class="flex justify-between mb-3 ">
                        <span class="quantity font-semibold text-sm uppercase"></span>
                    </div>
                    <div class="border-t mt-3">
                        <div class="flex font-semibold justify-between py-3 ms:text-sm sm:text-base uppercase">
                            <span>Tổng Tiền</span>
                            <span class="sum normal-case lg:text-xl md:text-lg sm:text-md text-base text-rose-500">đ 0</span>
                        </div>
                        <input type="text" class="peer sr-only" name="typeCheckout" value="0">
                        <button type="submit" name="btn-submit" id="btn-checkout" class="bg-green-500 font-semibold hover:bg-green-400 py-3 ms:text-sm sm:text-basetext-white uppercase w-full">Thanh
                            Toán </button>
                    </div>
                    <span class="err-shoppingcart md:text-base text-sm text-rose-500 mt-2 hidden"></span>
                </div>
            </div>
        </form>
    </main>
</div>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/navbar.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/cart.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/shoppingCart.js"></script>

</body>

</html>