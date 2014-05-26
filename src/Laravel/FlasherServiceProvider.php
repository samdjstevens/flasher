<?php namespace Spanky\Flasher\Laravel;

use Illuminate\Support\ServiceProvider;
use Spanky\Flasher\FlasherManager;
use Spanky\Flasher\MessageStore\LaravelSessionMessageStore;
use Illuminate\Session\SessionManager;

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
            $sessionManager = $this->app->make('Illuminate\Session\SessionManager');
            return new FlasherManager(new LaravelSessionMessageStore($sessionManager));
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