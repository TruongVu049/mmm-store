<?php
include "./helpers/view.php";
//phpMailer
include_once(__DIR__ . '../includes/phpmailer/Exception.php');
include_once(__DIR__ . '../includes/phpmailer/PHPMailer.php');
include_once(__DIR__ . '../includes/phpmailer/SMTP.php');

include "./classes/KhachHang.php";
view('header', ['title' => 'Quên mật khẩu']);

global $userId;
if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $db = new Database();

    $query = "SELECT id FROM khachhang WHERE email = '$email'";
    $statement = $db->conn->query($query);
    $data = $statement->fetch(PDO::FETCH_ASSOC);

    if (!empty($data)) {
        $userId = $data['id'];
        $forgotToken = sha1(uniqid() . time());


        $sql = "UPDATE khachhang SET forgotToken= :token WHERE id = :id";
        $dataUpdate = [
            'token' => $forgotToken,
            'id' => $userId
        ];

        $update = $db->update($sql, $dataUpdate);


        // host
        $link = "http://localhost/NOP_DE_TAI_LAN_3/Web_ThoiTrangTreEm/resetmk.php?token=" . $forgotToken;

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
                                    <p>Vui lòng truy cập vào đường dẫn này để tạo mật khẩu mới 
                                        <a href=' . $link . '>' . $link . '</a>
                                    </p>
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

        $send = $kh->guiEmail($email, "Forgot Password", $content);

        if ($send) {
            $notify = "<p class='text-green-500'>Gửi thành công</p>";
        } else {
            $notify = "<p class='text-red-500'>Gửi thất bại.</p>";
        }
    } else {
        $notify = "<p class='text-red-500'>Email không tồn tại.</p>";
    }
}

?>

<main class="relative">
    <div class="absolute inset-0 top-[-10rem] -z-10  overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
        <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" div="">
        </div>

    </div>
    <div class="relative">
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="mt-24 sm:mx-auto sm:w-full sm:max-w-sm shadow-2xl p-5 rounded-2xl duration-300 ease-linear">
                <form id="form" class="" action="quenmatkhau.php" method="POST">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Quên mật khẩu</h2>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-1">
                            <input value="<?php echo $_POST['email'] ?? "" ?>" id="email" name="email" type="email" autocomplete="email" required="Vui lòng điền vào email!" class="block w-full rounded-md  py-2 px-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-green-300 sm:text-sm sm:leading-6">
                            <?php
                            if (!empty($notify)) {
                                echo $notify;
                            }
                            ?>
                            <span class="errEmai hid md:text-base text-sm text-red-500"></span>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button id="send" name="send" type="submit" class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-2 px-1 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 ">Gửi</button>
                    </div>
                </form>
                <div>
                    <p class="mt-5 text-center text-sm text-gray-500"><a class="font-semibold leading-6 text-rose-500 hover:text-red-400 hover:underline  hover:underline-offset-4" href="dangnhap.php">Đăng nhập</a> | <a class="font-semibold leading-6 text-rose-500 hover:text-red-400 hover:underline  hover:underline-offset-4" href="dangky.php">Đăng ký</a></p>
                </div>
            </div>
        </div>
    </div>
</main>