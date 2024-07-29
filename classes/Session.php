<?php
class Session
{
    public static function init()
    {
        if (session_id() == '') {
            session_start();
        }
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function exp() //8h - 28800s
    {
        $expOld = self::get("exp");
        if ((time() - (int)$expOld) > 28800) {
            return true;
        } else {
            return false;
        }
    }
    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function checkSession()
    {
        self::init();
        if (self::get("adminlogin") == false) {
            self::destroy();
            header("Location:dangnhap.php");
        } else {
            header("Location:index.php");
        }
    }
    public static function checkAdmin()
    {
        self::init();
        if (self::get("isAdmin") == false) {
            self::destroy();
            header("Location:dangnhap.php");
        } else {
            if (self::exp() == true) {
                self::destroy();
                header("Location:dangnhap.php");
            }
        }
    }

    public static function checkAuth()
    {
        return self::get("cuslogin") == true;
    }

    public static function destroy()
    {
        session_destroy();
    }
}
