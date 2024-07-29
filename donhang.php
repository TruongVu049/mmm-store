<?php
include "./helpers/view.php";
view('header', ['title' => 'Đơn hàng']);
if (!Session::checkAuth()) {
    echo "<script>location.href = 'dangnhap.php'</script>";
}
// echo "<pre>";
// print_r($_SESSION);
// echo "<pre>";
?>
<main class="xl:container mx-auto lg:container sm:container py-10  ">
    <div class="tabs">
        <div class="border-b border-gray-200 bg-white shadow-sm border border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-700 ">
                <li class=" mr-2"><a id="tab1" class="active border-b-2 rounded-t-lg text-rose-500  border-rose-500    inline-flex  p-4 items-center justify-center group cursor-pointer">Chờ xác nhận</a></li>
                <li class="mr-2"><a id="tab2" class=" border-b-2  rounded-t-lg border-transparent hover:text-rose-500 hover:border-rose-500  inline-flex  p-4 items-center justify-center group cursor-pointer">Đang vận chuyển</a></li>
                <li class="mr-2"><a id="tab3" class=" border-b-2  rounded-t-lg border-transparent hover:text-rose-500 hover:border-rose-500  inline-flex  p-4 items-center justify-center group cursor-pointer ">Hoàn thành</a></li>
                <li class="mr-2"><a id="tab4" class=" border-b-2  rounded-t-lg border-transparent hover:text-rose-500 hover:border-rose-500  inline-flex  p-4 items-center justify-center group cursor-pointer ">Đã hủy</a></li>
            </ul>
        </div>
        <div class="mt-6">
            <!-- loading -->
            <section class="loader flex flex-col gap-5 border border-gray-200 shadow-md bg-white">
                <div class="animate-pulse">
                    <div class="bg-white p-4    mb-4">
                        <div class="flex items-center justify-between ">
                            <div class="h-2.5 bg-gray-300 rounded-full  w-32 mb-2.5"></div>
                            <div class="h-2.5 bg-gray-300 rounded-full  w-32 mb-2.5"></div>
                        </div>
                        <div class="py-2  border-y border-gray-200 border-solid">
                            <div class="flex gap-2">
                                <div class="h-20 w-20 bg-gray-300 "></div>
                                <div class="w-full">
                                    <div class="h-4 bg-gray-300 rounded-full  w-[50%] mb-2.5"></div>
                                    <div class="h-4 bg-gray-300 rounded-full  w-[70%] mb-2.5"></div>
                                    <div class="h-4 bg-gray-300 rounded-full  w-[90%] mb-2.5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="py-2  border-y border-gray-200 border-solid">
                            <div class="flex gap-2">
                                <div class="h-20 w-20 bg-gray-300 "></div>
                                <div class="w-full">
                                    <div class="h-4 bg-gray-300 rounded-full  w-[50%] mb-2.5"></div>
                                    <div class="h-4 bg-gray-300 rounded-full  w-[70%] mb-2.5"></div>
                                    <div class="h-4 bg-gray-300 rounded-full  w-[90%] mb-2.5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end flex-col items-end mt-2">
                            <div class="h-2.5 bg-gray-300 rounded-full  w-32 mb-2.5"></div>
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>
            </section>
            <div class="content flex flex-col gap-5 border border-gray-200 shadow-md bg-white">
            </div>
        </div>
    </div>
</main>

<div id="modal_nofi" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen ">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-lg shadow ">
                <form id="formC" class="p-3">
                    <h3 class="text-left mb-3 md:text-lg text-md  font-semibold text-gray-900 border-b border-gray-300 pb-3">Thông báo</h3>
                    <p class="text-gray-600 md:text-base text-sm ">Bạn có muốn hủy đơn hàng này không?</p>
                    <input type="text" name="orderId" class="peer sr-only " />
                    <div class="flex items-center gap-3 justify-end mt-4">
                        <button id="btn-close-modalC" type="button" class="text-gray-800  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Trở lại</button>
                        <button type="submit" class="text-white bg-rose-500 hover:bg-rose-600 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal-comment" class="hidden  relative z-10">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-40 transition-opacity">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full justify-center p-4 text-center items-center sm:p-0">
                <form id="form-comment" method="post" action="#" class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-[70%] w-[90%]">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h4 class="capitalize md:text-2xl sm:text-xl text-lg">
                            Đánh giá sản phẩm
                        </h4>
                        <div class="flex items-start gap-2 py-4">
                            <input type="text" name="orderId" class="sr-only">
                            <div>
                                <img class="modal-comment-img h-20 w-20" src="" />
                            </div>
                            <div>
                                <h4 class="line-clamp-2 modal-comment-name sm:line-clamp-none line-clamp-1 sm:text-base text-sm">

                                </h4>
                                <span class="modal-comment-type text-gray-600 md:text-sm text-xs"></span>
                            </div>
                        </div>
                        <div class="flex items-center md:text-lg sm:text-base text-sm gap-2 flex-wrap">
                            <h6 class="sm:mr-8">Chất lượng sản phẩm</h6>
                            <div class="flex items-center ">
                                <label class="cursor-pointer">
                                    <input data-value="1" value="1" type="checkbox" name="star" class="peer sr-only" value="" />
                                    <svg size="40" class="w-10 h-10 peer-checked:text-yellow-500 text-gray-300 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                </label>
                                <label class="cursor-pointer">
                                    <input data-value="2" value="2" type="checkbox" name="star" class="peer sr-only" value="" />
                                    <svg size="40" class="w-10 h-10 peer-checked:text-yellow-500 text-gray-300 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                </label>
                                <label class="cursor-pointer">
                                    <input data-value="3" value="3" type="checkbox" name="star" class="peer sr-only" value="" />
                                    <svg size="40" class="w-10 h-10 peer-checked:text-yellow-500 text-gray-300 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                </label>
                                <label class="cursor-pointer">
                                    <input data-value="4" value="4" type="checkbox" name="star" class="peer sr-only" value="" />
                                    <svg size="40" class="w-10 h-10 peer-checked:text-yellow-500 text-gray-300 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                </label>
                                <label class="cursor-pointer">
                                    <input data-value="5" value="5" type="checkbox" name="star" class="peer sr-only" value="" />
                                    <svg size="40" class="w-10 h-10 peer-checked:text-yellow-500 text-gray-300 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                    </svg>
                                </label>
                            </div>
                            <span>

                            </span>
                        </div>
                        <div>
                            <label htmlFor="mes" class="block py-4 font-medium md:text-lg sm:text-base text-sm">
                                Nội dung đánh giá
                            </label>
                            <textarea id="mes" name="mes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-rose-500 focus:border-rose-500 " placeholder=""></textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 flex sm:flex-nowrap flex-wrap flex-row-reverse sm:px-6 gap-4">
                        <button type="submit" class="border-rose-500 border-2 border-solid px-10 py-2 bg-rose-500 hover:bg-rose-400  text-white">
                            Hoàn thành
                        </button>
                        <button type="button" class="close-modal-comment border-rose-500 border-2 border-solid text-rose-500 px-10 py-2 hover:bg-rose-500 hover:text-white">
                            Trở lại
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/navbar.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/cart.js"></script>
<script type="text/javascript" src="<?php __DIR__ ?>public/js/order.js"></script>
</body>

</html>