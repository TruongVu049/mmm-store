<?php
include_once(__DIR__ . '/Database.php');
include_once(__DIR__ . '/../helpers/Fomat.php');
include_once(__DIR__ . '/../includes/config.php');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class KhachHang
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function ktKhachHang($data)
    {
        try {
            $ktEmail = $this->db->selectNonParam("select * from khachhang where khachhang.email = '" . $data['email'] . "'");
            if (count($ktEmail) > 0) {
                return "Email đã được sử dụng, vui lòng nhập một email khác!";
            }
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
    }
    public function themKhachHang($data)
    {
        try {
            $ktEmail = $this->db->selectNonParam("select * from khachhang where khachhang.email = '" . $data['email'] . "'");
            if (count($ktEmail) > 0) {
                return "Email đã được sử dụng, vui lòng nhập một email khác!";
            } else {
                $this->db->conn->beginTransaction();
                $query = "INSERT into khachhang(khachhang.email, khachhang.matkhau, khachhang.ten) values('" . $data['email'] . "', '" . password_hash($data['password'], PASSWORD_DEFAULT) . "', '" . $data['username'] . "')";
                $khId = $this->db->insertNonParam($query);
                $this->db->conn->commit();
            }
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
    }
    public function danhNhap($data)
    {
        try {
            $kh = $this->db->selectNonParam("select * from khachhang where khachhang.email = '" . $data['email'] . "'");
            if (!(count($kh) > 0)) {
                return false;
            } else {
                if (!password_verify($data['password'], $kh[0]['matkhau'])) {
                    return false;
                }
            }
            return [
                "id" => $kh[0]['id'],
                "email" => $kh[0]['email'],
                "ten" => $kh[0]['ten'],
                "sdt" => $kh[0]['sdt']
            ];
        } catch (PDOException $e) {
            return false;
        }
    }

    public function layThongTin($id)
    {
        try {
            $kh = $this->db->selectNonParam("select khachhang.id, khachhang.email, khachhang.ten, khachhang.sdt from khachhang where khachhang.id = $id");
            $dc = $this->db->selectNonParam("select diachi.id, diachi.sdt, diachi.diachi, diachi.diachicuthe, diachi.macdinh     from diachi where diachi.KhachHang_id = $id");
            return [
                'kh' => $kh[0],
                'dc' => $dc,
            ];
        } catch (PDOException $err) {
            return false;
        }
    }
    public function themDiaChi($data)
    {
        try {
            $this->db->conn->beginTransaction();
            $query = "insert into diachi(diachi.sdt, diachi.diachi, diachi.diachicuthe, diachi.KhachHang_id, diachi.macdinh) VALUES('" . $data['sdt'] . "', '" . $data['diachi'] . "', '" . $data['diachicuthe'] . "', " . $data['KhachHang_id'] . ", " . $data['macdinh'] . ")";
            $dcId = $this->db->insertNonParam($query);
            if ($data['macdinh'] == 1) {
                $this->db->updateNonParam("update diachi set macdinh = 0 where diachi.id != $dcId");
            }
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
    }
    public function layDiaChi($id)
    {
        try {
            $dc = $this->db->selectNonParam("select * from diachi where diachi.KhachHang_id = $id  order by diachi.macdinh DESC");
            return $dc;
        } catch (PDOException $err) {
            return false;
        }
    }

    public function capNhatDiaChi($data)
    {
        try {
            $this->db->conn->beginTransaction();
            $query = "UPDATE diachi set diachi.sdt = '" . $data['sdt'] . "', diachi.diachi = '" . $data['diachi'] . "', diachi.diachicuthe = '" . $data['diachicuthe'] . "', diachi.macdinh = " . $data['macdinh'] . " where diachi.id = " . $data['id'];
            $this->db->updateNonParam($query);
            if ($data['macdinh'] == 1) {
                $this->db->updateNonParam("update diachi set macdinh = 0 where diachi.id != " . $data['id']);
            }
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
    }
    public function xoaDiaChi($id)
    {
        try {
            $this->db->conn->beginTransaction();
            $query = "DELETE FROM diachi WHERE diachi.id = $id";
            $this->db->deleteNonParam($query);
            $this->db->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->conn->rollBack();
            return "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
        }
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
