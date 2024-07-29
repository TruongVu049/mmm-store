<?php

require './includes/phpmailer/Exception.php';
require './includes/phpmailer/PHPMailer.php';
require './includes/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class GuiMailDonHang
{
    public function __construct()
    {
    }
    public function guiEmail($email, $subject, $content)
    {

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = PHPMailer_HOST;                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = PHPMailer_USERNAME;            //SMTP username
            $mail->Password   = PHPMailer_PASSWORD;                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = "utf-8";
            //Recipients
            $mail->setFrom(PHPMailer_ADDRESS, 'MMM');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = '
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title></title>
            </head>
            <body>
                ' . $content . '
            </body>
            </html>
            ';
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
