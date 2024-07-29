<?php
include_once("./includes/header.php");
include_once "../classes/KhuyenMai.php";

$km = new KhuyenMai();

$limit = 8;
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
$offset = ($p - 1) * $limit;
$t = $km->laySLKhuyenMai();
$tongTrang = (int)(ceil($t / $limit));

$dsKM = $km->layKhuyenMai($offset, $limit, $sapxep);
if (isset($_POST["remove_id"])) {
    $r = $km->xoaKhuyenMai($_POST["remove_id"]);
    if ($r) {
        $dsKM = $km->layKhuyenMai($offset,$limit, $sapxep);
    }
}

?>
<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Khuyến mãi</h1>
        </div>
    </div>
    <div class="flex flex-col items-center space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="pt-2 relative  text-gray-600 sm:w-auto w-full">
            <div>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                    <div class="flex sm:items-center sm:justify-between sm:flex-row flex-col items-start gap-4">
                        <div class="sm:w-auto w-full">
                            <label for="sort" class="sr-only mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                            <select onchange="this.form.submit()" name="sx" id="sort" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option <?php if ($sapxep == "") {
                                            echo "selected";
                                        } ?> value="">Mặc định</option>
                                <option <?php if ($sapxep == "phantram_asc") {
                                            echo "selected";
                                        } ?> value="phantram_asc">Phần trăm tăng dần</option>
                                <option <?php if ($sapxep == "phantram_desc") {
                                            echo "selected";
                                        } ?> value="phantram_desc">Phần trăm giảm dần</option>
                                <option <?php if ($sapxep == "phantram_conhan") {
                                            echo "selected";
                                        } ?> value="phantram_conhan">Khuyến mãi còn hạn</option>
                                <option <?php if ($sapxep == "phantram_hethan") {
                                            echo "selected";
                                        } ?> value="phantram_hethan">Khuyến mãi hết hạn</option>
                            </select>
                        </div>
                        <input type="submit" class="sr-only" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-wrap items-start justify-end -mb-3">
            <a href="themkhuyenmai.php">
                <button class="inline-flex px-5 py-3 text-white bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 rounded-md ml-6 mb-3">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-white -ml-1 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Thêm Khuyến Mãi
                </button>
            </a>
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
                        Tên
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Phần trăm
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ngày bắt đầu
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ngày kết thúc
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Số sản phẩm áp dụng
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($dsKM) { ?>
                    <?php
                    foreach ($dsKM as $item) { ?>
                        <tr class="bg-white border-b hover:bg-gray-50 ">
                            <td class="px-6 py-4 text-gray-900">
                                <span><?php echo $item["id"] ?></span>
                            </td>
                            <td class="px-6 py-4 text-gray-900 ">
                                <h4 class=" line-clamp-2"><?php echo $item["ten"] ?></h4>
                            </td>
                            <td class="px-6 py-4 text-gray-900 ">
                                <h4 class=" "><?php echo $item["phantram"] . "%" ?></h4>
                            </td>
                            <td class="px-6 py-4 text-gray-900">
                                <span><?php $date = date_create($item["thoigian_bd"]);
                                        echo date_format($date, "d/m/Y"); ?></span>
                            </td>
                            <td class="px-6 py-4 text-gray-900">
                                <span><?php
                                        if (is_null($item['thoigian_kt'])) {
                                            echo "---";
                                        } else {
                                            $date = date_create($item["thoigian_kt"]);
                                            echo date_format($date, "d/m/Y");
                                        }

                                        ?></span>

                            </td>
                            <td class="px-6 py-4 text-gray-900">
                                <span><?php echo $item["sl"]; ?></span>
                            </td>
                            <td class="px-6 py-4 ">
                                <div class="flex items-center space-x-3">
                                    <a href="suakhuyenmai.php?kmid=<?php echo $item["id"] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                            <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"></path>
                                            <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"></path>
                                        </svg>
                                    </a>
                                    <button data-id="<?php echo $item["id"] ?>" type="button" class="btn_open_modal font-medium text-red-600 dark:text-red-500 hover:underline">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php  }  ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <br>
    <div class="flex sm:justify-end justify-center items-center">
        <div class="inline-flex -space-x-px text-base h-10 py-2">
            <?php
            $prevP = $p > 0 ? $p - 1 : 0;
            $nextP = $p >= $tongTrang ? $p : $p + 1;
            ?>
            <?php if ($p <= 1) : ?>
                <a href="khuyenmai.php?p=<?php echo $prevP ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="opacity-50 pointer-events-none cursor-default flex items-center justify-center px-4 h-10 leading-tight text-blue-500 bg-white border border-gray-300 rounded-l-lg hover:bg-blue-500 hover:text-white ">
                    <svg class="w-6 h-6 text-gray-600 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13" />
                    </svg>
                </a>
            <?php else : ?>
                <a href="khuyenmai.php?p=<?php echo $prevP ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class=" flex items-center justify-center px-4 h-10 leading-tight text-blue-500 bg-white border border-gray-300 rounded-l-lg hover:bg-blue-500 hover:text-white ">
                    <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13" />
                    </svg>
                </a>
            <?php endif; ?>
            <ul class="sm:inline-flex hidden">
                <?php
                for ($i = 1; $i <= $tongTrang; $i++) {
                    if ($i == $p) { ?>
                        <a href="khuyenmai.php?p=<?php echo $i ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="flex items-center justify-center px-4 h-10 text-white border border-gray-300 bg-blue-500  hover:bg-blue-600 hover:text-white "><?php echo $i ?></a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="khuyenmai.php?p=<?php echo $i ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-blue-500 bg-white border border-gray-300 hover:bg-blue-500 hover:text-white "><?php echo $i ?></a>
                        </li>
                <?php }
                }
                ?>
            </ul>

            <?php if ($p >= $tongTrang) : ?>
                <a href="khuyenmai.php?p=<?php echo $nextP ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class="opacity-50 pointer-events-none cursor-default flex items-center justify-center px-4 h-10 leading-tight text-blue-500 bg-white border border-gray-300 rounded-r-lg hover:bg-blue-500 hover:text-white ">
                    <svg class="w-6 h-6 text-gray-600 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1" />
                    </svg>
                </a>
            <?php else : ?>
                <a href="khuyenmai.php?p=<?php echo $nextP ?><?php echo $sapxep ? "&sx=$sapxep" : "" ?>" class=" flex items-center justify-center px-4 h-10 leading-tight text-blue-500 bg-white border border-gray-300 rounded-r-lg hover:bg-blue-500 hover:text-white ">
                    <svg class="w-6 h-6 text-gray-600 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</main>
<div id="modal_remove" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen ">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" id="form_modal_remove" method="post">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Thông báo</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        <span>Bạn có chắc chắn muốn xóa khuyến mãi có ID là </span>
                                        <span class="dl_id"></span>
                                        <input type="text" class="sr-only" name="remove_id" id="remove_id">
                                        <span> không?</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Xác nhận</button>
                        <button id="close_modal_remove" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function handleSearch() {
        document.getElementById('.submit_on_enter').addEventListener('keypress', function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
    }
    document.querySelectorAll(".btn_open_modal").forEach(item => {
        item.addEventListener("click", () => {
            const modal_remove = document.getElementById("modal_remove");
            modal_remove.classList.remove("hidden");
            document.getElementById("remove_id").value = item.dataset.id;
            document.querySelector(".dl_id").innerHTML = item.dataset.id;
        })
    })
    document.getElementById("close_modal_remove").addEventListener('click', () => {
        document.getElementById("modal_remove").classList.add("hidden");
    })
</script>

<?php
include_once("./includes/footer.php")
?>