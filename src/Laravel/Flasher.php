<?php namespace Spanky\Flasher\Laravel;

use Illuminate\Support\Facades\Facade;

class Flasher extends Facade {

    /**
     * Return the name of the binding in the
     * IoC.
     *
     * @return string
     */
    public static function getFacadeAccessor() 
    {
        return 'flasher';
    }
}