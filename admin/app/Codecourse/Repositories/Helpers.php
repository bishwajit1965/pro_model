<?php

namespace CodeCourse\Repositories;

class Helpers
{
    /**
     * Will show formatted date
     *
     * @param  Data $data Commented
     * @return  $data
     */
    public function dateFormat($date)
    {
        return date('F j, Y, g:i a', strtotime($date));
    }
    /**
     * Text shortener method
     *
     * @param  text $text commented 
     * @param  integer $limit commented
     * @return void
     */
    public function textShorten($text, $limit = 400)
    {
        $text = $text . " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text . ".....";
        return $text;
    }
    /**
     * Will validate and trim data
     *
     * @param  Data $data commented about this variable
     * @return  Data $data Commented
     */
    public function validation($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    /**
     * Title to be made upper case
     *
     * @return void
     */
    public function title()
    {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');
        if ($title == 'index') {
            $title = 'home';
        } elseif ($title == 'contact') {
            $title = 'contact';
        } elseif ($title == 'testimonials') {
            $title = 'testimonials';
        }
        return $title = ucwords($title);
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
