<?php
/**
 * @package        OpenCart
 * @author        Daniel Kerr
 * @copyright    Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license        https://opensource.org/licenses/GPL-3.0
 * @link        https://www.opencart.com
 */

/**
 * Action class
 */
class Action
{
    private $id;
    private $route;
    private $method = 'index';

    /**
     * Constructor
     *
     * @param    string $route
     */
    public function __construct($route)
    {
        $this->id = $route;

        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));

        // Break apart the route
        while ($parts) {
            $file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';

            if (is_file($file)) {
                $this->route = implode('/', $parts);

                break;
            } else {
                $this->method = array_pop($parts);
            }
        }
    }

    /**
     *
     *
     * @return    string
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     *
     * @param    object $registry
     * @param    array $args
     */
    public function execute($registry, array $args = array())
    {
        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            return new \Exception('Error: Calls to magic methods are not allowed!');
        }
//@4945 For Override
//$base_u=str_replace('system/','',DIR_SYSTEM);
//$insidefolder='override/'.str_replace($base_u,'',DIR_APPLICATION);
//$file_override  = DIR_MODIFICATION . $insidefolder.'controller/' . $this->route . '.php'; 
        $file_override = DIR_APPLICATION_OVERRIDE . 'controller/' . $this->route . '.php';
		$class_override = 'Kiranacontroller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->route);
//@4945 END For Override		
        $file = DIR_APPLICATION . 'controller/' . $this->route . '.php';
        $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->route);
        // Initialize the class
        if (is_file($file_override)) { //@4945 For Override
		    include_once($file);
            include_once($file_override);
            $controller = new $class_override($registry);
        } else if (is_file($file)) {
            include_once($file);

            $controller = new $class($registry);
        } else {
            return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }

        $reflection = new ReflectionClass($class);

        if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
            return call_user_func_array(array($controller, $this->method), $args);
        } else {
            return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }
    }
}
