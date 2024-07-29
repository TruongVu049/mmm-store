<?php
ob_start();
include_once("./includes/header.php");
require_once("../classes/Database.php");

$db = new Database();


if(isset($_POST['themkhachhang'])){
    // Kiểm tra xem các dữ liệu cần thiết đã được gửi từ biểu mẫu hay không
    $tenkh = $_POST['tenkhachhang'];
    $email = $_POST['email'];
    $matkhau = $_POST['matkhau'];
    $sdt = $_POST['sdt'];
    if(isset($tenkh, $email, $matkhau, $sdt)){
        // Tạo câu lệnh SQL để chèn một khách hàng mới vào cơ sở dữ liệu
        $sql = "INSERT INTO khachhang ( email, matkhau, sdt,ten) VALUES ( :email, :matkhau, :sdt,:ten)";
        
        try{
            // Chuẩn bị câu lệnh SQL
            $statement = $db->conn->prepare($sql);
    
            // Gán giá trị cho các tham số
            $data = [
                'ten' => $tenkh,
                'email' => $email,
                'matkhau' => $matkhau,
                'sdt' => $sdt,
            ];
        
            // Thực thi truy vấn
            $insertStatus = $statement->execute($data);

            // Chuyển hướng người dùng sau khi thêm thành công
            header('Location: khachhang.php');
        } catch(Exception $exception){
            // Xử lý ngoại lệ nếu có
            echo "Lỗi: " . $exception->getMessage();
        }
    }
}

?>
<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Thêm Khách Hàng</h1>
        </div>
    </div>

    <div>
        <form action="themkhachhang.php" method="post" class="bg-white">
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Email</label><br>

                <input type="text" name="email" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email" required />
            </div>
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Mật khẩu</label><br>

                <input type="text" name="matkhau" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Mật khẩu" required />
            </div>
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Số điện thoại</label><br>

                <input type="text" name="sdt" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Số điện thoại" required />
            </div>
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Tên Khách hàng</label><br>

                <input type="text" name="tenkhachhang" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tên Khách Hàng" required />
            </div>
            <input type="submit" name="themkhachhang" value="Thêm Khách Hàng" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        </form>

    </div>


</main>
<script>
</script>

<?php
include_once("./includes/footer.php");
ob_end_flush();

?>