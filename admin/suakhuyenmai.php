<?php
include_once("./includes/header.php");
include_once "../classes/KhuyenMai.php";

$km = new KhuyenMai();

if (isset($_GET['kmid'])) {
    $spkm = $km->layKhuyenMaiId($_GET['kmid']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $suaKhuyenMai = $km->suaKhuyenMai($_POST);
    if ($suaKhuyenMai) {
        $spkm = $km->layKhuyenMaiId($_GET['kmid']);
    }
}
?>

<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Sửa khuyến mãi</h1>
        </div>
    </div>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="myForm" runat="server" class="p-6 bg-white shadow rounded-lg" style="background-color: #fff">
        <input name="id" value="<?php echo $spkm['id'] ?>" type="text" class="sr-only bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        <div class="mb-6">
            <label for="ten" class="block mb-2 text-sm font-medium text-gray-900 ">Tên khuyến mãi</label>
            <input disabled required name="ten" value="<?php echo $spkm['ten'] ?>" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
        </div>
        <div class="mb-6">
            <label for="phantram" class="block mb-2 text-sm font-medium text-gray-900 ">Phần trăm khuyến mãi</label>
            <input required name="phantram" value="<?php echo $spkm['phantram'] ?>" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
        </div>
        <div class="mb-6">
            <label for="thoigian_kt" class="block mb-2 text-sm font-medium text-gray-900 ">Thời gian bắt đầu</label>
            <input type="date" name="thoigian_bd" value="<?php echo date('Y-m-d', strtotime($spkm["thoigian_bd"])) ?>" disabled class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
        </div>
        <input type="text" name="data" class="sr-only" />
        <div class="mb-6">
            <div class="flex items-center peer">
                <input name='them_thoigian_kt' <?php echo $spkm['thoigian_kt'] ? "checked" : "" ?> id="checked-checkbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600  focus:ring-2 dark:bg-gray-700 ">
                <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">Thêm thời gian kết thúc</label>
            </div>
            <div class="peer-has-[:checked]:block hidden">
                <label for="thoigian_kt" class="block mb-2 text-sm font-medium text-gray-900 "></label>
                <input value="<?php echo date('Y-m-d', strtotime($spkm["thoigian_kt"])) ?>" type="date" name="thoigian_kt" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
        </div>

        <div class="mb-6 flex justify-between items-center">
            <label for="options" class="block mb-2 text-sm font-medium text-gray-900 ">Sản phẩm áp dụng</label>
            <button type="button" id="btn_open" class="inline-flex px-4 py-2 text-base text-white bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 rounded-md ml-6 mb-3">
                <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-white -ml-1 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Thêm sản phẩm
            </button>
        </div>
        <div id="product-checked" class="relative mb-6">
            <?php if (!is_null($spkm['sanpham'])) : ?>
                <?php
                foreach ($spkm['sanpham'] as $sp) { ?>
                    <div class="flex p-2 items-center border border-gray-200 sm:rounded-lg rounded-base">
                        <div class="flex items-center w-20">
                            <img class="h-16" src="<?php echo $sp['hinhanh'] ?>" alt="">
                        </div>
                        <input checked name="proId[]" value="<?php echo $sp['id'] ?>" class="sr-only" />
                        <div class="flex  justify-between ml-4 flex-grow">
                            <span class="text-sm"><?php echo $sp['ten'] ?></span>
                            <button type="button" class="">
                                <svg data-product-checked-id="<?php echo $sp['id'] ?>" class="font-semibold hover:text-red-500 text-gray-500 text-xs w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6m0 12L6 6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php }

                ?>
            <?php endif; ?>
        </div>
        <div id="error" class="hidden mb-2 text-rose-500 sm:text-base text-sm"></div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
            Lưu
        </button>
    </form>
</main>
<script>
    var ds = <?php echo json_encode($spkm['sanpham']); ?>;
    document.querySelector("input[name='data']").value = JSON.stringify(ds);
</script>
<div id="modal-option" class="hidden fixed inset-0 transition z-[200]">
    <div class="absolute inset-0"></div>
    <div id="container__search" class="bg-gray-600 bg-opacity-40 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
        <div class="container mx-auto">
            <form id="form_options" class="p-6 bg-white shadow rounded-lg text-left" style="background-color: #fff">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="pt-6  h-96 relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg">
                    <table id="tb_listProduct" class="w-full max-h-80 text-sm overflow-y-auto text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100  ">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tên
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Giá
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <div class="w-full p-4 space-y-4 border border-gray-200 divide-y divide-gray-200 rounded shadow animate-pulse md:p-6 ">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="h-2.5 bg-gray-300 rounded-full  w-24 mb-2.5"></div>
                                                <div class="w-56 h-2 bg-gray-200 rounded-full "></div>
                                            </div>
                                            <div class="h-2.5 bg-gray-300 rounded-full  w-24"></div>
                                        </div>
                                        <div class="flex items-center justify-between pt-4">
                                            <div>
                                                <div class="h-2.5 bg-gray-300 rounded-full  w-24 mb-2.5"></div>
                                                <div class="w-56 h-2 bg-gray-200 rounded-full "></div>
                                            </div>
                                            <div class="h-2.5 bg-gray-300 rounded-full  w-24"></div>
                                        </div>
                                        <div class="flex items-center justify-between pt-4">
                                            <div>
                                                <div class="h-2.5 bg-gray-300 rounded-full  w-24 mb-2.5"></div>
                                                <div class="w-56 h-2 bg-gray-200 rounded-full "></div>
                                            </div>
                                            <div class="h-2.5 bg-gray-300 rounded-full  w-24"></div>
                                        </div>
                                        <div class="flex items-center justify-between pt-4">
                                            <div>
                                                <div class="h-2.5 bg-gray-300 rounded-full  w-24 mb-2.5"></div>
                                                <div class="w-56 h-2 bg-gray-200 rounded-full "></div>
                                            </div>
                                            <div class="h-2.5 bg-gray-300 rounded-full  w-24"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- render -->
                        </tbody>
                    </table>
                    <div class="my-2 text-center">
                        <button type="button" id="btn-show-more" class="py-2 px-4 border border-rose-500 hover:bg-rose-500 hover:text-white rounded-lg text-rose-500">Xem thêm</button>
                    </div>
                </div>
                <div id="error_listProduct" class="hidden mt-4 text-rose-500 sm:text-base text-sm"></div>
                <div class="text-right mt-6">
                    <button type="button" id="btn_close" class="mr-4 opacity-80 inline-flex px-4 py-2 text-base text-white bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 rounded-md ">
                        Hủy
                    </button>
                    <button type="button" id="btn_add" class="inline-flex px-4 py-2 text-base text-white bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 rounded-md ">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_nofi" class="<?php echo isset($suaKhuyenMai) ? "" : "hidden" ?> relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen ">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button id="close_nofi" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <?php if (isset($suaKhuyenMai)) {
                        if ($suaKhuyenMai) { ?>
                            <svg class="mx-auto mb-4 text-green-500 bg-white  w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        <?php } else { ?>
                            <svg class="mx-auto mb-4 text-red-500 bg-white  w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                    <?php }
                    }
                    ?>

                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"><?php if (isset($suaKhuyenMai)) {
                                                                                                if ($suaKhuyenMai) {
                                                                                                    echo "Đã lưu lại thay đổi thành công!";
                                                                                                } else {
                                                                                                    echo "Đã xảy ra lỗi, vui lòng thực hiện lại!";
                                                                                                }
                                                                                            } ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./js/promotion.js"></script>
<script>
    document.querySelector("#close_nofi").addEventListener("click", () => {
        document.querySelector("#modal_nofi").classList.add("hidden");
    })
</script>
<?php
include_once("./includes/footer.php")
?>