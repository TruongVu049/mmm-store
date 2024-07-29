<?php
include_once("./includes/header.php");
require_once("../classes/Database.php");

$db = new Database();

global $rowCount;
$display = 8;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = "";
}

if ($page == "" || $page == 1) {
    $begin = 0;
} else {
    $begin = ($page * $display) - $display;
}

if (isset($_POST['searchdm'])) {
    $searchValue = $_POST['searchValue'];
    $sql = "SELECT * FROM `danhmuc` WHERE `ten` LIKE '%$searchValue%' ORDER BY `id` ASC LIMIT $begin, $display";
} else {
    $sql = "SELECT * FROM `danhmuc` ORDER BY `id` ASC LIMIT $begin, $display";
}
$data = $db->selectNonParam($sql);

?>

<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Danh mục</h1>
        </div>
    </div>

    <div>
        <form action="danhmuc.php" method="post" novalidate>
            <a href="themdanhmuc.php" class="mb-5 mr-6 inline-block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Thêm danh mục</a>

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
                        <th class="p-3 text-sm tracking-wide">Tên danh mục</th>
                        <th class="p-3 text-sm tracking-wide">Sửa</th>
                        <th class="p-3 text-sm tracking-wide">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


                    foreach ($data as $row) {
                    ?>
                        <tr class="bg-white border-b-2">
                            <th class="p-3 text-sm text-center text-gray-700"><?php echo $row['id'] ?></th>
                            <td class="p-3 text-sm text-center text-gray-700"><?php echo $row['ten'] ?></td>

                            <td class="p-3 text-sm text-center text-gray-700">
                                <a href="suadanhmuc.php?id=<?php echo $row['id'] ?>" class="inline-block text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Sửa</a>
                            </td>

                            <td class="p-3 text-sm text-center text-gray-700">
                                <a onclick="return xoaDanhMuc()" href="xoadanhmuc.php?id=<?php echo $row['id'] ?>" class="inline-block focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Xóa</a>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation example" class="mt-5 w-full text-center">
                <ul class="inline-flex -space-x-px text-base h-10">
                    <?php

                    if (isset($_POST['searchValue'])) {
                        $sql_page = "SELECT * FROM `danhmuc` WHERE `ten` LIKE '%$searchValue%'";
                    } else {
                        $sql_page = 'SELECT * FROM `danhmuc`';
                    }
                    $stateMent = $db->conn->prepare($sql_page);
                    $stateMent->execute();
                    $rowCount = $stateMent->rowCount();
                    $page = ceil($rowCount / $display);

                    for ($i = 1; $i <= $page; $i++) {
                        $isActive = isset($_GET['page']) && $_GET['page'] == $i ? "bg-gray-300" : "";
                    ?>
                        <li>
                            <a href="danhmuc.php?page=<?php echo $i ?>" class="flex items-center justify-center px-6 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 bg-gray-800 text-gray-400 hover:bg-gray-200 hover:text-white <?php echo $isActive ?>"><?php echo $i ?></a>
                        </li>
                    <?php } ?>

                </ul>
            </nav>

        </form>
    </div>


</main>

<script>
    function xoaDanhMuc() {
        var conf = confirm("Bạn có chắc chắn muốn xóa không?");
        return conf;
    }
</script>

<?php
include_once("./includes/footer.php")
?>