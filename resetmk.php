<?php
include "./helpers/view.php";
include "./classes/KhachHang.php";

view('header', ['title' => 'Đặt lại mật khẩu']);

global $userId;
$db = new Database();

if (!empty($_GET['token']))
    $token = $_GET['token'];
$query = "SELECT id FROM khachhang WHERE forgotToken = '$token'";
$statement = $db->conn->query($query);
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!empty($data)) {
    $userId = $data['id'];
    if (isset($_POST['password'], $_POST['password-confirm'])) {
        $sql = "UPDATE khachhang SET forgotToken= :token, matkhau=:matkhau WHERE id = :id";
        $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $dataUpdate = [
            'matkhau' => $passwordHash,
            'token' => null,
            'id' => $userId
        ];

        $update = $db->update($sql, $dataUpdate);

        if ($update) {
            echo "<h3 class='border p-5 bg-green-200 text-green-500'>Đổi mật khẩu thành công. Đang chuyển hướng.....</h3>";

            echo "<script>
            setTimeout(function() {
                window.location.href = 'dangnhap.php';
            }, 3000);
          </script>";
        }
    }

?>
    <main class="relative">
        <div class="absolute inset-0 top-[-10rem] -z-10  overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" <="" div="">
            </div>

        </div>
        <div class="relative">
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                <div class="mt-24 sm:mx-auto sm:w-full sm:max-w-sm shadow-2xl p-5 rounded-2xl duration-300 ease-linear">
                    <form id="form" action="resetmk.php?token=<?php echo $_GET['token'] ?>" method="POST" novalidate>
                        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Đặt lại mật khẩu</h2>
                        <div>
                            <div class="mt-3">
                                <div class="flex items-center justify-between duration-300 ease-linear"><label for="password" class="block text-sm font-medium leading-6 text-gray-900">Mật khẩu</label></div>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="current-password" required="Vui lòng điền vào mật khẩu!" class="block w-full rounded-md  py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                                    <span class="errPassword hid md:text-base text-sm text-red-500"></span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="flex items-center justify-between"><label for="password-confirm" class="block text-sm font-medium leading-6 text-gray-900">Xác nhận mật khẩu</label></div>
                                <div class="mt-1">
                                    <input id="password-confirm" name="password-confirm" type="password" autocomplete="current-password" required="Vui lòng điền vào mật khẩu xác nhận!" class="block w-full rounded-md  py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                                    <span class="errPassword2 hidden  md:text-base text-sm text-red-500"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="err  md:text-base text-sm text-red-500"></span>
                            <button id="btn-submit" name="btn-submit" type="submit" class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-2 px-1 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ">Gửi</button>
                        </div>
                    </form>
                    <div>
                        <p class="mt-5 text-center text-sm text-gray-500"><a class="font-semibold leading-6 text-rose-500 hover:text-red-400 hover:underline  hover:underline-offset-4" href="dangnhap.php">Đăng nhập</a> | <a class="font-semibold leading-6 text-rose-500 hover:text-red-400 hover:underline  hover:underline-offset-4" href="dangky.php">Đăng ký</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="./public/js/validate.js"></script>
<?php



} else {
    echo "<h3 class='border border-amber-400 p-5 bg-red-200	 text-red-500'>Trang không tồn tại hoặc đã hết hạn</h3>";
}


?>