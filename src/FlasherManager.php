<?php namespace Spanky\Flasher;

use Spanky\Flasher\MessageStore\MessageStoreInterface;
use Spanky\Flasher\Collections\MessageCollection;
use InvalidArgumentException;
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
        $message = $this->validateMessage($message);
        $type = $this->validateType($type);
        // Validate the parameters

        return $this->messageStore->add($message, $type);
        // Add the message into the message store
    }

    /**
     * Validate a message.
     * 
     * @param  mixed $message
     * @return string
     */
    private function validateMessage($message) 
    {
        if (! is_string($message) and ! (is_object($message) and method_exists($message, '__toString'))) 
        {
            throw new InvalidArgumentException(
                "Message must be of type string, or implement the __toString method."
            );
        }
        // Ensure the message is either a string, or an
        // object that implements the __toString method

        return (string) $message;
        // Cast to string if an object
    }

    /**
     * Validate a message type.
     * 
     * @param  mixed $message
     * @return string
     */
    private function validateType($type) 
    {
        if (is_null($type)) 
        {
            return 'default';
        }
        // If no type specified, give it 'default'

        if (! is_string($type) and ! (is_object($type) and method_exists($type, '__toString'))) 
        {
            throw new InvalidArgumentException(
                "Type must be of type string, or implement the __toString method."
            );
        }
        // Ensure the message is either a string, or an
        // object that implements the __toString method

        return (string) $type;
        // Cast to string if an object
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
