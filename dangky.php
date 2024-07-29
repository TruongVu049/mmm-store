<?php
include "./helpers/view.php";
include "./classes/KhachHang.php";

//phpMailer
include_once(__DIR__ . '../includes/phpmailer/Exception.php');
include_once(__DIR__ . '../includes/phpmailer/PHPMailer.php');
include_once(__DIR__ . '../includes/phpmailer/SMTP.php');

view('header', ['title' => 'Đăng ký']);

if (Session::checkAuth()) {
    echo "<script>location.href = 'index.php'</script>";
}

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['email'], $_POST['username'])) {
    $dkyKh = new KhachHang();
    $dky = $dkyKh->ktKhachHang($_POST);
    if ($dky === true) {
        $email = $_POST['email'];
        $token = sha1(uniqid() . time());
        $content = '
                <table border="0" cellspacing="0" cellpadding="0" style="max-width:600px">
                <tbody>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            MMM
                                        </td>
                                        <td align="right">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr height="16"></tr>
                    <tr>
                        <td>
                            <table bgcolor="#4184F3" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width:332px;max-width:600px;border:1px solid #e0e0e0;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px">
                                <tbody>
                                    <tr>
                                        <td height="72px" colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="32px"></td>
                                        <td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:24px;color:#ffffff;line-height:1.25">Mã xác minh MMM</td>
                                        <td width="32px"></td>
                                    </tr>
                                    <tr>
                                        <td height="18px" colspan="3"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table bgcolor="#FAFAFA" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:1px solid #c0c0c0;border-top:0;border-bottom-left-radius:3px;border-bottom-right-radius:3px">
                                <tbody>
                                    <tr height="16px">
                                        <td width="32px" rowspan="3"></td>
                                        <td></td>
                                        <td width="32px" rowspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Xin chào!</p>
                                            <p>Mã xác minh bạn cần dùng để truy cập vào Tài khoản MMM của mình (
                                                <span style="color:#659cef" dir="ltr">
                                                    <a href="mailto:' . $email . '" target="_blank">' . $email . '</a>
                                                </span>) là:
                                            </p>
                                            <div style="text-align:center">
                                                <p dir="ltr"><strong style="text-align:center;font-size:24px;font-weight:bold">' . $token . '</strong></p>
                                            </div>
                                            <p> Trân trọng!</p>
                                        </td>
                                    </tr>
                                    <tr height="32px"></tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';
        $kh = new KhachHang();
        $send = $kh->guiEmail($email, "Xác nhận Email", $content);
        if ($send) {
            Session::set("token", $token);
            Session::set("email", $email);
            Session::set("password", $_POST['password']);
            Session::set("username", $_POST['username']);
            echo "<script>location.href = 'xacthucemail.php';</script>";
        } else {
            $notify = "<p class='text-red-500'>Gửi thất bại.</p>";
        }
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
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Đăng ký</h2>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-1">
                            <input value="<?php echo $_POST['email'] ?? "" ?>" id="email" name="email" type="email" autocomplete="email"  class="block w-full rounded-md  py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                            <span class="errEmai hid md:text-base text-sm text-red-500"></span>
                        </div>
                    </div>
                    <div>
                        <div class="mt-3">
                            <div class="flex items-center justify-between duration-300 ease-linear"><label for="username" class="block text-sm font-medium leading-6 text-gray-900">Họ Tên</label></div>
                            <div class="mt-1">
                                <input value="<?php echo $_POST['username'] ?? "" ?>" id="username" name="username" type="text" autocomplete="username" required="Vui lòng điền vào họ tên!" class="block w-full rounded-md py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                                <span class="errUserName hid md:text-base text-sm text-red-500"></span>
                            </div>
                        </div>
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
                                <span class="errPassword2 hidden  md:text-base text-sm text-red-500">asdasd</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="err  md:text-base text-sm text-red-500"><?php
                                                                                if (isset($dky) && $dky !== true) {
                                                                                    echo $dky;
                                                                                }
                                                                                ?></span>
                        <a href="dangnhap.php">
                            <button id="btn-submit" name="btn-submit" type="submit" class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-2 px-1 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ">Đăng Ký</button>
                        </a>
                    </div>
                </form>
                <div>
                    <p class="mt-10 text-center text-sm text-gray-500">Bạn đã có tài khoản <a class="font-semibold leading-6 text-rose-500 hover:text-red-400 hover:underline  hover:underline-offset-4" href="dangnhap.php">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="./public/js/validate.js"></script>
<script src="./public/js/navbar.js"></script>