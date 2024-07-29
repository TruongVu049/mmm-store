<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require "./includes/phpmailer/Exception.php";
require "./includes/phpmailer/PHPMailer.php";
require "./includes/phpmailer/SMTP.php";
require "./includes/config.php";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = PHPMailer_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = PHPMailer_USERNAME;            //SMTP username
    $mail->Password   = PHPMailer_PASSWORD;
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
    $mail->SMTPSecure = 'tls';      //Doi lai cai nay
    $mail->Port       = 587;
    $mail->CharSet = "utf-8";

    //Recipients
    //$mail->setFrom('truongvu0188@gmail.com'); //lay du lieu tu from
    //$mail->addAddress($_POST["email"], $_POST["tenkhachhang"]);     //Tai khoan nguoi nha co the thay bang email cua ong

    $mail->setFrom($_POST["email"], $_POST["tenkhachhang"]); //tai khoan nguoi gui
    $mail->addAddress(PHPMailer_ADDRESS, 'Nguyen Tan Truong Vu');     //Tai khoan nguoi nhan 

    $mail->isHTML(true);
    $mail->Subject = "Phản hồi";
    $mail->Body    = '
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title></title>
            </head>
            <body>
            <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#">Nội dung</a></h2>
            <p class="mb-5 font-light text-gray-500 dark:text-gray-400">' . $_POST["content"] . '</p>
            </body>
            </html>
            ';
    $mail->send();
    echo '
    <h2>Phản hồi đã được gửi thành công</h2>
    <a style="margin-left: 12px ;padding: 4px 8px; background-color: blue; color: white;" href="lienhe.php">Trở lại</a>
    ';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
