<?php namespace Spanky\Flasher;

use Spanky\Flasher\MessageStore\SessionMessageStore;

class Factory {

    /**
     * Make an instance of the FlasherManager.
     * 
     * @param  mixed $messageStore
     * @return Spanky\Flasher\FlasherManager
     */
    public static function make($messageStore = null) 
    {
        if (is_null($messageStore)) $messageStore = new SessionMessageStore;
        // If no message store object provided, 
        // use an instance of SessionMessageStore 
        
        return new FlasherManager($messageStore);
    }
}