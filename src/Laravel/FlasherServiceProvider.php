<?php namespace Spanky\Flasher\Laravel;

use Illuminate\Support\ServiceProvider;
use Spanky\Flasher\Factory;

class FlasherServiceProvider extends ServiceProvider {

    /**
     * Register the package in the IoC.
     * 
     * @return void
     */
    public function register() 
    {
        $this->app->bind('flasher', function() 
        {
            return Factory::make();
        });
    }

    /**
     * Return an array of container keys this service 
     * provider creates.
     * 
     * @return array
     */

    public function provides()
    {
        return array('flasher');
    }
}