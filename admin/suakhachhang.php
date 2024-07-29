<?php
ob_start();
include_once("./includes/header.php");
require_once("../classes/Database.php");

$db = new Database();

$id = $_GET["id"];

$sql = "SELECT * FROM khachhang WHERE id = $id";
$statement = $db->conn->prepare($sql);
$statement->execute();
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['suakhachhang'])) {
    try {
        $tenkh = $_POST['tenkhachhang'];
         $email = $_POST['email'];
        $matkhau = $_POST['matkhau'];
        $sdt = $_POST['sdt'];
        if(isset($tenkh, $email, $matkhau, $sdt)){
            $sql = "UPDATE khachhang SET email=:email, matkhau=:matkhau, ten=:ten, sdt=:sdt WHERE id=:id";

            $statement = $db->conn->prepare($sql);
            
            $statement->bindParam(':email', $_POST['email']);
            $statement->bindParam(':matkhau', $_POST['matkhau']);
            $statement->bindParam(':ten', $_POST['tenkhachhang']);
            $statement->bindParam(':sdt', $_POST['sdt']);
            $statement->bindParam(':id', $id);

            $update = $statement->execute();
        }

        header('Location: khachhang.php');
    } catch (Exception $exception) {
    }
}



?>
<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Sửa Khách Hàng</h1>
        </div>
    </div>

    <div>
        <form action="suakhachhang.php?id=<?php echo $id ?>" method="post" class="bg-white">
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Email</label><br>

                <input type="text" name="email" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo $data["email"] ?>" required />
            </div>
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Mật khẩu</label><br>

                <input type="text" name="matkhau" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo $data["matkhau"] ?>" required />
            </div>
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Số điện thoại</label><br>

                <input type="text" name="sdt" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo $data["sdt"] ?>" required />
            </div>
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Tên Khách hàng</label><br>

                <input type="text" name="tenkhachhang" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo $data["ten"] ?>" required />
            </div>
            <input type="submit" name="suakhachhang" value="Sửa Khách Hàng" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

        </form>
    </div>


</main>
<script>
</script>

<?php
include_once("./includes/footer.php");
ob_end_flush();
?>