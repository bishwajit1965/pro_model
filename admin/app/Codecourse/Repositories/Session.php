<?php

namespace CodeCourse\Repositories;

class Session
{
    /**
     * Session initiating method
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
     * Undocumented function
     *
     * @param  key $key commented
     * @param  val $val commented
     * @return void
     */
    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    /**
     * Undocumented function
     *
     * @param  key $key should be dealt
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
            header('Location:index.php');
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
     * Redirect url function.
     *
     * @param url $url commented
     *
     * @return void
     */
    public function redirect($url)
    {
        header('Location:' . $url);
    }
}
