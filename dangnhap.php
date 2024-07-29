<?php
include "./helpers/view.php";
include "./classes/KhachHang.php";
view('header', ['title' => 'Đăng nhập']);

if (Session::checkAuth()) {
    echo "<script>location.href = 'index.php'</script>";
}

?>
<?php
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['email'], $_POST['password'])) {
    $dnhapKh = new KhachHang();
    $dnhap = $dnhapKh->danhNhap($_POST);
    if ($dnhap != false) {
        Session::set("cuslogin", true);
        Session::set("cusId", $dnhap['id']);
        Session::set("cusName", $dnhap['ten']);
        Session::set("cusEmail", $dnhap['email']);
        Session::set("exp", time());
        if (trim($_POST['historyState']) != "undefined" && ('' === "chitietsanpham.php?spid" || false !== strpos(trim($_POST['historyState']), "chitietsanpham.php?spid"))) {
            echo "<script>location.href='" . trim($_POST['historyState']) . "'</script>";
        } else {
            echo "<script>location.href='index.php'</script>";
        }
    }
}

?>
<script>
    window.addEventListener("load", () => {
        document.querySelector("input[name='historyState']").value = history.state?.prevUrl;
    })
</script>

<main class="relative">
    <div class="absolute inset-0 top-[-10rem] -z-10  overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
        <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" <="" div="">
        </div>

    </div>
    <div class="relative">
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="mt-24 sm:mx-auto sm:w-full sm:max-w-sm shadow-2xl p-5 rounded-2xl duration-300 ease-linear">
                <form id="form" class="" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Đăng nhập</h2>
                    <input name="historyState" type="text" class="peer sr-only">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-1">
                            <input value="<?php echo $_POST['email'] ?? "" ?>" id="email" name="email" type="email" autocomplete="email"  class="block w-full rounded-md  py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                            <span class="errEmai hid md:text-base text-sm text-red-500"></span>
                        </div>
                    </div>
                    <div>
                        <div class="mt-3">
                            <div class="flex items-center justify-between duration-300 ease-linear"><label for="password" class="block text-sm font-medium leading-6 text-gray-900">Mật khẩu</label>
                                <div><a href="quenmatkhau.php" class="font-semibold text-rose-400 hover:text-red-300  hover:underline  hover:underline-offset-4">Quên mật khẩu?</a></div>
                            </div>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <span class="err  md:text-base text-sm text-red-500"><?php echo isset($dnhap) && $dnhap == false ? "Thông tin email và mật khẩu không chính xác!" : "" ?></span>
                        <a href="dangnhap.php">
                            <button id="btn-submit" name="btn-submit" type="submit" class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-2 px-1 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ">Đăng Nhập</button>
                        </a>
                    </div>
                </form>
                <div>
                    <p class="mt-10 text-center text-sm text-gray-500">Bạn chưa có tài khoản <a class="font-semibold leading-6 text-rose-500 hover:text-red-400 hover:underline  hover:underline-offset-4" href="dangky.php">Đăng ký</a></p>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="./public/js/validate.js"></script>
<script src="./public/js/navbar.js"></script>
