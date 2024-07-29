<?php
include "./helpers/view.php";
include "./classes/KhachHang.php";
view('header', ['title' => 'Xác thực Email']);

if (Session::checkAuth() || !Session::get('token')) {
    echo "<script>location.href = 'index.php'</script>";
}

// Session::set("token", $token);
// Session::set("email", $email);
// Session::set("password", $_POST['password']);
// Session::set("username", $_POST['username']);

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['maxacnhan'])) {
    if ($_POST['maxacnhan'] ===  Session::get('token')) {
        $kh = new KhachHang();
        $dky = $kh->themKhachHang([
            "email" => Session::get('email'),
            "password" => Session::get('password'),
            "username" => Session::get('username')
        ]);
        unset($_SESSION['token']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        unset($_SESSION['username']);
    } else {
        $err = "Mã xác nhận không khớp!";
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
                <form id="form" class="" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Xác nhận Email</h2>
                    <div>
                        <label for="maxacnhan" class="block text-sm font-medium leading-6 text-gray-900">Mã xác nhận</label>
                        <div class="mt-1">
                            <input id="maxacnhan" name="maxacnhan" type="text" required class="block w-full rounded-md  py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <span class="d:text-base text-sm text-red-500"><?php echo $err ?? "" ?></span>
                    <div class="mt-4">
                        <button id="btn-submit" name="btn-submit" type="submit" class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-2 px-1 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<div id="modal_nofi" class=" <?php echo isset($dky) && $dky === true ? "" : "hidden" ?> relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen ">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button id="close_nofi" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">

                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-green-500 bg-white  w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Đăng ký tài khoản thành công. Đang chuyển hướng...</h3>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- <script src="./public/js/validate.js"></script> -->
<?php
if (isset($dky) && $dky === true) {
    echo "<script> setTimeout(() => { location.href = 'dangnhap.php'; }, 2000); </script>";
}
?>