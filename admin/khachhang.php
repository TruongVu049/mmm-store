<?php
include_once("./includes/header.php");
require_once("../classes/Database.php");

$db = new Database();

$result = $db->selectNonParam("SELECT * FROM khachhang where khachhang.PhanQuyen_id != 1");

$results_per_page = 8;

$number_of_result = count($result);

$number_of_page = ceil($number_of_result / $results_per_page);

if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$page_first_result = ($page - 1) * $results_per_page;

$query = "SELECT * FROM khachhang  where khachhang.PhanQuyen_id != 1 LIMIT " . $page_first_result . ',' . $results_per_page;
$khachhangs = $db->selectNonParam($query);



if (isset($_POST['searchdm'])) {
    $searchValue = $_POST['searchValue'];
    $sql = "SELECT * FROM `khachhang` WHERE khachhang.PhanQuyen_id != 1 and `ten` LIKE '%$searchValue%' ORDER BY `id` ASC LIMIT $page_first_result, $results_per_page";
} else {
    $sql = "SELECT * FROM `khachhang` where khachhang.PhanQuyen_id != 1 ORDER BY `id` ASC LIMIT $page_first_result, $results_per_page";
}
$khachhangs = $db->selectNonParam($sql);
?>





<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Khách hàng</h1>
        </div>

    </div>


    <div>
        <form action="khachhang.php" method="post">
            <a href="themkhachhang.php" class="mb-5 inline-block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Thêm Khách Hàng</a>
            <div class="relative inline-block w-1/2">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" name="searchValue" class="block w-full h-10 p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 border-gray-300 text-gray focus:ring-blue-500 focus:border-blue-500" placeholder="Tên" required />
                <button type="submit" name="searchdm" class="text-white absolute end-2 bottom-1 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-1.5 bg-blue-600 focus:ring-blue-500">Tìm kiếm</button>
            </div>

            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-500">
                    <tr>
                        <th class="p-3 text-sm tracking-wide">ID</th>
                        <th class="p-3 text-sm tracking-wide">email</th>
                        <th class="p-3 text-sm tracking-wide">Sdt</th>
                        <th class="p-3 text-sm tracking-wide">Ten</th>
                        <th class="p-3 text-sm tracking-wide">Hanh Dong</th>


                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($khachhangs as $khachhang) : ?>

                        <tr class="bg-white border-b-2">
                            <th class="p-3 text-sm text-center text-gray-700"><?php echo $khachhang['id'] ?></th>
                            <td class="p-3 text-sm text-center text-gray-700"><?php echo $khachhang['email'] ?></td>
                            <td class="p-3 text-sm text-center text-gray-700"><?php echo $khachhang['sdt'] ?></td>
                            <td class="p-3 text-sm text-center text-gray-700"><?php echo $khachhang['ten'] ?></td>

                            <td class="p-3 text-sm text-center text-gray-700">
                                <a href="suakhachhang.php?id=<?php echo $khachhang['id'] ?>" class="inline-block text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Sửa</a>
                                <a onclick="return xoaDanhMuc()" href="xoakhachhang.php?id=<?php echo $khachhang['id'] ?>" class="inline-block focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Xóa</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <div class="flex justify-end pt-4 mt-4 border-t dark:border-gray-700">
                <nav aria-label="page-navigation">
                    <ul class="flex list-style-none">
                        <li>
                            <a class="relative block px-3 py-1.5 mr-3 text-base hover:text-blue-700 transition-all duration-300 hover:bg-blue-200 dark:hover:text-gray-400 dark:hover:bg-gray-700 rounded-md text-gray-100 bg-blue-600" href="khachhang.php?page=<?php echo $page - 1 ?>">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $number_of_page; $i++) {
                            if ($page == $i) { ?>
                                <li>
                                    <a class="relative block px-3 py-1.5 mr-3 text-base hover:text-blue-700 transition-all duration-300 hover:bg-blue-200 dark:hover:text-gray-400 dark:hover:bg-gray-700 rounded-md text-gray-100 bg-blue-600" href="khachhang.php?page=<?php echo $i ?>"><?php echo $i ?></a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a class="relative block px-3 py-1.5 mr-3 text-base hover:text-blue-700 transition-all duration-300 hover:bg-blue-200 dark:hover:text-gray-400 dark:hover:bg-gray-700 rounded-md text-gray-100 bg-blue-600" href="khachhang.php?page=<?php echo $i ?>"><?php echo $i ?></a>
                                </li>
                        <?php }
                        } ?>
                        <li>
                            <a class="relative block px-3 py-1.5 mr-3 text-base hover:text-blue-700 transition-all duration-300 hover:bg-blue-200 dark:hover:text-gray-400 dark:hover:bg-gray-700 rounded-md text-gray-100 bg-blue-600" href="khachhang.php?page=<?php echo $page + 1 ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </form>

    </div>


    <script>
        function xoaDanhMuc() {
            var conf = confirm("Bạn có chắc chắn muốn xóa không?");
            return conf;
        }
    </script>
    </div>
    <?php
    include_once("./includes/footer.php")
    ?>