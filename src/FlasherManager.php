<?php namespace Spanky\Flasher;

use Spanky\Flasher\MessageStore\MessageStoreInterface;
use Spanky\Flasher\Collections\MessageCollection;
use BadMethodCallException;

class FlasherManager {

    /**
     * Inject the MessageStore implementation 
     * into the class.
     * 
     * @param MessageStoreInterface $messageStore
     */
    public function __construct(MessageStoreInterface $messageStore) 
    {
        $this->messageStore = $messageStore;
    }

    /**
     * Add a flash message.
     * 
     * @param mixed $message
     * @param mixed $type
     */
    public function addMessage($message, $type = null) 
    {
        $type = $this->validateType($type);
        // Validate the parameters

        $message = new FlashMessage($message, $type);

        return $this->messageStore->add($message);
        // Add the message into the message store
    }



    /**
     * Determine if there are messages to
     * be shown or not.
     * 
     * @param  string  $type
     * @return boolean
     */
    public function hasMessages($type = null) 
    {
        $messages = $this->getMessages($type);

        return count($messages) > 0;
    }

    /**
     * Get all the messages to be shown.
     * 
     * @param  string $type
     * @return Spanky\Flasher\MesageCollection
     */
    public function getMessages($type = null) 
    {
        if (is_null($type)) 
        {
            $messages = $this->messageStore->getAll();
        }
        else
        {
            $messages = $this->messageStore->getAllByType($type);
        }
        // Get the messages, depending on whether or not
        // a type was specified

        return new MessageCollection($messages);
        // Return a new MessageCollection containing
        // the messages
    }

    /**
     * Magic method to allow for dynamic 
     * method calls when adding messages.
     * e.g. addSuccess(), addError()
     * 
     * @param  string $method
     * @param  array  $args
     * @return mixed
     */
    public function __call($method, $args) 
    {
        if (substr($method, 0, 3) === 'add') 
        {
            // If the (non-existing) method name
            // begins with "add", assume that 
            // they want to add a message with
            // the type of whatever comes next.

            $type = lcfirst(substr($method, 3));

            if ($type === '') $type = null;
            // If no type text was specified,
            // then set to null

            $message = isset($args[0]) ? $args[0] : null;
            // Get the message

            return $this->addMessage($message, $type);
            // Add the message
        }

        throw new BadMethodCallException("Method '{$method}' not found in " . __CLASS__);
        // Throw an exception detailing the missing method
    }
}
