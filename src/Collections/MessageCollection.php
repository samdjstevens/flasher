<?php namespace Spanky\Flasher\Collections;

use Spanky\Flasher\FlashMessage;

class MessageCollection extends AbstractCollection {

    /**
     * Transform a message array into an
     * object.
     * 
     * @param  array $message
     * @return Spanky\Flasher\FlashMessage
     */
    public function transform(array $message) 
    {
        extract($message);
        return new FlashMessage($message, $type);
    }
}