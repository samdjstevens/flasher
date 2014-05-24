<?php namespace Spanky\Flasher\MessageStore;

use Spanky\Flasher\FlashMessage;

class SessionMessageStore implements MessageStoreInterface {

    /**
     * The key to store the messages under in 
     * the session.
     * 
     * @var string
     */
    private $sessionKey = 'spanky.flasher.messages';

    /**
     * The messages in the store.
     * 
     * @var array
     */
    private $messages = array();

    /**
     * Load the messages in from 
     * the session when instantiated.
     */
    public function __construct() 
    {
        $this->loadMessages();
    }

    /**
     * Load in previously set messages from
     * the session, and then forget them.
     */
    public function loadMessages() 
    {
        if (array_key_exists($this->sessionKey, $_SESSION)) 
        {
            // If there are messages to grab
            $this->messages = $_SESSION[$this->sessionKey];
            // Load in the messages

            unset($_SESSION[$this->sessionKey]);
            // And then forget them from the session
            
            $this->messages = array_map(function($message) 
            {
                return new FlashMessage($message['content'], $message['type']);

            }, $this->messages);
            // Loop through the messages and convert to FlashMessage objects
        }
    }

    /**
     * Add a message into the store.
     * 
     * @param Spanky\Flasher\FlashMessage $message
     */
    public function add(FlashMessage $message) 
    {
        $flashMessage = array(

            'content'   => $message->getContent(), 
            'type'      => $message->getType()

        );
        // Create a new message from the message

        array_push($this->messages, $message);
        // Add it to the internal array

        $_SESSION[$this->sessionKey][] = $flashMessage;
        // And to the session for the next load
    }

    /**
     * Get all the messages in the store.
     * 
     * @return array
     */
    public function getAll() 
    {
        return $this->messages;
    }

    /**
     * Get all the messages of a particular
     * type in the store.
     *
     * @param  string $type
     * @return array
     */
    public function getAllByType($type) 
    {
        return array_filter($this->messages, function($message) use ($type)
        {
            return $message->getType() === $type;
        });
    }
}