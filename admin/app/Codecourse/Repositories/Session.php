<?php

namespace CodeCourse\Repositories;

class Session
{
    /**
     * Session initiating and php version checking method
     *
     * @return void
     */
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

    /**
     * Method to set session value
     *
     * @param int    $key 
     * @param string $val 
     * 
     * @return void
     */
    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    /**
     * Undocumented function
     *
     * @param key $key should be dealt
     * 
     * @return key
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false; 
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function checkSession()
    {
        self::init();
        if (self::get('login') == false) {
            self::destroy();
            header('Location:login.php');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function checkLogin()
    {
        self::init();
        if (self::get('login') == true) {
            return true;
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function destroy()
    {
        session_destroy();
        session_unset();
        header('Location:login.php');
    }

    /**
     * Redirect url method
     *
     * @param url $url 
     *
     * @return void
     */
    public function redirect($homeUrl)
    {
        header('Location:'.$homeUrl);
    }
}
