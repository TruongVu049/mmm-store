<?php
include_once "../classes/Admin.php";
include_once "../classes/Session.php";
Session::init();
if (Session::get("isAdmin") == true) {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../public/js/tailwindcss.bundle.js"></script>
    <link rel="shortcut icon" href="../public/images/favicon.png" type="image/x-icon" />
    <title>Đăng nhập</title>
</head>

<?php

$ad = new Admin();
if (isset($_POST["email"], $_POST["pwd"])) {
    $msg = $ad->dangNhap($_POST["email"], $_POST["pwd"]);
}
?>

<body>
    <div>
        <div class="relative  h-[100vh]  ">
            <div class="absolute inset-0 top-[-10rem] -z-10  overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
                <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" <="" div="">
                </div>
            </div>
            <div class="relative  h-full">
                <div class="flex h-[100%] flex-1 items-center justify-center  ">
                    <div class="sm:mx-auto sm:w-full w-[80%] sm:max-w-sm shadow-2xl p-5 rounded-2xl duration-300 ease-linear">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            <input name="__RequestVerificationToken" type="hidden" value="mb5ZN1MMhRj1eQrcgC2oDdY6fU-Ecw2YJ-LrhwEk68Cfv14C0lPMyjVB5VquCplhLbz0lTVyv69NP1jOkXy0iMwWyWE3CIzq-5mFaZQhgBE1">
                            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                                Đăng nhập
                            </h2>
                            <div class="mt-2">
                                <div class="flex items-center justify-between duration-300 ease-linear">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="email">Email</label>
                                </div>
                                <div class="mt-2">
                                    <input class="block w-full rounded-md py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-titleSMColor placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-box single-line" id="email" name="email" required type="text" value="">
                                    <span class="field-validation-valid text-red-500" data-valmsg-for="Email" data-valmsg-replace="true"></span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="flex items-center justify-between duration-300 ease-linear">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="pwd">Mật khẩu</label>
                                </div>
                                <div class="mt-2">
                                    <input class="block w-full rounded-md py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-titleSMColor placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-box single-line password" id="pwd" name="pwd" type="password">
                                    <span class="field-validation-valid text-red-500" data-valmsg-for="Password" data-valmsg-replace="true"></span>
                                </div>
                            </div>
                            <?php if (isset($msg)) : ?>
                                <div>
                                    <span class="text-rose-500 md:text-sm text-xs"><?php echo $msg ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="mt-8">
                                <button type="submit" class="bg-violet-400 duration-200 hover:bg-violet-500 flex w-full justify-center rounded-md text-neutral-950   py-2  text-sm font-semibold leading-6  shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Đăng Nhập
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <a target="_blank" href="../index.php" class="absolute top-0 left-0 mt-4 ml-4">
                    <button type="button" class="text-gray-900 border-2 border-purple-500 px-4 py-2 rounded-lg hover:bg-purple-500 hover:text-white hover:border-white sm:mr-4">
                        <span class="sm:block hidden">Chuyển đến trang chính</span>
                        <span class="sm:hidden block">Trang chính</span>
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>