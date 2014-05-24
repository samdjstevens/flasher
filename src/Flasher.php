<?php namespace Spanky\Flasher;

class Flasher {

    /**
     * The instance of the FlasherManager.
     * 
     * @var Spanky\Flasher\FlasherManager
     */
    private static $instance;

    /**
     * Get the instance of FlasherManager,
     * creating it via the Factory class
     * if it hasn't been created already.
     * 
     * @return Spanky\Flasher\FlasherManager
     */
    private static function getInstance() 
    {
        if (is_null(self::$instance)) 
        {
            self::$instance = Factory::make();
        }

        return self::$instance;
    }

    /**
     * When a static method on this class is
     * called, we'll resolve the instance of
     * FlasherManager and call the method
     * on that.
     * 
     * @param  string $method
     * @param  array  $args
     * @return mixed
     */
    public static function __callStatic($method, $args) 
    {
        $instance = self::getInstance();

        return call_user_func_array(array($instance, $method), $args);
    }
}