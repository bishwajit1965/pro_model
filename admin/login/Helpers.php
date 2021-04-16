<?php

namespace CodeCourse\Repositories;

/**
 * Class Helpers
 */
class helpers
{
    /**
     * Date format
     *
     * @param string $date
     *
     * @return void
     */
    public function dateFormat($date)
    {
        return date('F j, Y, g:i a', strtotime($date));
    }
    /**
     * Will shorten text
     *
     * @param string $text
     * @param integer $limit
     *
     * @return void
     */
    public function textShorten($text, $limit = 400)
    {
        $text = $text . ' ';
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text . '.....';

        return $text;
    }
    /**
     * Will validate data
     *
     * @param string $data
     *
     * @return void
     */
    public function validation($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
    /**
     * Will get the file name
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
}
