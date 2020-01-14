<?php

namespace CodeCourse\Repositories;

class Session
{
    // Verify php version and then will start session
    public static function init()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    // Session key is set
    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    // Session key is grabbed
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    // Session state Checking
    public static function checkSession()
    {
        self::init();
        if (self::get('login') == false) {
            self::destroy();
            header('Location:login.php');
        }
    }

    // Checking login
    public static function checkLogin()
    {
        self::init();
        if (self::get('login') == true) {
            header('Location:index.php');
        }
    }

    // Destroying session ang logging out
    public static function destroy()
    {
        session_destroy();
        session_unset();
        header('Location:login.php');
    }
}
