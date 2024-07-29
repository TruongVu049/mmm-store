<?php
include(__DIR__ . '/Session.php');
include_once(__DIR__ . '/Database.php');
include_once(__DIR__ . '/../helpers/Fomat.php');
?>
<?php
class Admin
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function Admin($email, $matkhau)
    {
        // if (count($result) != 0) {
        //     $value = $result->fetch_assoc();
        //     Session::set("Admin", true);
        //     Session::set("adminId", $value['adminId']);
        //     Session::set("adminUser", $value['adminUser']);
        //     Session::set("adminName", $value['adminName']);
        //     Session::set("lavel", $value['lavel']);
        //     // header("Location:dashboard.php");
        // } else {
        //     $loginmsg = "Username or Password not match!";
        //     return $loginmsg;
        // }
    }
    public function dangNhap($email, $matkhau)
    {
        $adminUser = $this->fm->validation($email);
        $adminPass = $this->fm->validation($matkhau);

        $query = "select * from khachhang where email = '$email' and matkhau = '$matkhau'";
        $result = $this->db->selectNonParam($query);
        if (count($result) != 0 && $result[0]['PhanQuyen_id'] == 1) {
            Session::init();
            Session::set("isAdmin", true);
            Session::set("email", $result[0]['email']);
            Session::set("ten", $result[0]['ten']);
            Session::set("exp", time());
            header("Location:index.php");
        } else {
            return "Email và mật khẩu không chính xác!";
        }
    }
}
