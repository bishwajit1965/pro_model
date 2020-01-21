<?php

namespace CodeCourse\Repositories;

class Helpers
{
    /**
     * Will show formatted date
     *
     * @param [type] $data
     * @return $data
     */
    public function dateFormat($date)
    {
        return date('F j, Y, g:i a', strtotime($date));
    }
    /**
     * Will shorten text
     *
     * @param [type] $text
     * @param [type] $limit
     * @return $text and $limit
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
     * @param [type] $data
     * @return $data
     */
    public function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    /**
     * Will change title to upper case
     *
     * @param [type] $title
     * @return $title
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
}
