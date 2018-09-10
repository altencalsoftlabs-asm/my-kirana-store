<?php
/**
 * @package        OpenCart
 * @author        Daniel Kerr
 * @copyright    Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license        https://opensource.org/licenses/GPL-3.0
 * @link        https://www.opencart.com
 */

/**
 * Language class
 */
class Language
{
    private $default = 'en-gb';
    private $directory;
    public $data = array();

    /**
     * Constructor
     *
     * @param    string $file
     *
     */
    public function __construct($directory = '')
    {
        $this->directory = $directory;
    }

    /**
     *
     *
     * @param    string $key
     *
     * @return    string
     */
    public function get($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : $key);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     *
     *
     * @return    array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     *
     *
     * @param    string $filename
     * @param    string $key
     *
     * @return    array
     */
    public function load($filename, $key = '')
    {
        if (!$key) {
            $_ = array();
            //print DIR_LANGUAGE;

            $file = DIR_LANGUAGE . $this->default . '/' . $filename . '.php';

            if (is_file($file)) {
                require($file);
            }
            //PATCH @4945
            //$base_u=str_replace('system/','',DIR_SYSTEM);
            //$insidefolder='override/'.str_replace($base_u,'',DIR_LANGUAGE);
            //$file_override  = DIR_MODIFICATION . $insidefolder . $this->directory . '/' . $filename . '.php';
            $file_override = DIR_LANGUAGE_OVERRIDE . $this->directory . '/' . $filename . '.php';
            $file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';
            if (is_file($file_override)) {
                require($file_override);
            } else if (is_file($file)) {
                require($file);
            }

            $this->data = array_merge($this->data, $_);
        } else {
            // Put the language into a sub key
            $this->data[$key] = new Language($this->directory);
            $this->data[$key]->load($filename);
        }

        return $this->data;
    }
}