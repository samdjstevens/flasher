<?php namespace Spanky\Flasher\MessageStore;

use Spanky\Flasher\FlashMessage;

interface MessageStoreInterface {

    /**
     * Add a message into the store.
     * 
     * @param Spanky\Flasher\FlashMessage $message
     */
    public function add(FlashMessage $message);

    /**
     * Get all the messages in the store.
     * 
     * @return array
     */
    public function getAll();

    /**
     * Get all the messages of a particular
     * type in the store.
     *
     * @param  string $type
     * @return array
     */
    public function getAllByType($type);
}