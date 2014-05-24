<?php namespace Spanky\Flasher;

use Spanky\Flasher\MessageStore\DefaultMessageStore;

class Flasher {

    private static $instance;

    private static function getInstance() 
    {
        if (is_null(self::$instance)) 
        {
            self::$instance = new FlasherManager(new DefaultMessageStore);
        }

        return self::$instance;

    }



    public static function __callStatic($method, $args) 
    {
        $instance = self::getInstance();
        return call_user_func_array(array($instance, $method), $args);
    }
}