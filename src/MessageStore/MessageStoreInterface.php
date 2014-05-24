<?php namespace Spanky\Flasher\MessageStore;

interface MessageStoreInterface {

    /**
     * Add a message into the store.
     * 
     * @param string $message
     * @param mixed  $type
     */
    public function add($message, $type = null);

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