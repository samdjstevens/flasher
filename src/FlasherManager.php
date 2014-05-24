<?php namespace Spanky\Flasher;

use Spanky\Flasher\MessageStore\MessageStoreInterface;
use Spanky\Flasher\Collections\MessageCollection;
use BadMethodCallException;

class FlasherManager {

    /**
     * The message store implementation.
     * 
     * @var Spanky\Flasher\MessageStore\MessageStoreInterface
     */
    private $messageStore;

    /**
     * Inject the MessageStore implementation 
     * into the class.
     * 
     * @param Spanky\Flasher\MessageStore\MessageStoreInterface $messageStore
     */
    public function __construct(MessageStoreInterface $messageStore) 
    {
        $this->messageStore = $messageStore;
    }

    /**
     * Get the message store implementation.
     * 
     * @return Spanky\Flasher\MessageStore\MessageStoreInterface
     */
    public function getMessageStore() 
    {
        return $this->messageStore;
    }

    /**
     * Add a flash message.
     * 
     * @param mixed $content
     * @param mixed $type
     */
    public function addMessage($content, $type = null) 
    {
        $message = new FlashMessage($content, $type);
        // Create a new FlashMessage with the content
        // and type

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
     * @return Spanky\Flasher\MessageCollection
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
            // Extract the type from the method
            // name

            if ($type === '') $type = null;
            // If no type text was specified,
            // then set to null

            $content = isset($args[0]) ? $args[0] : null;
            // Get the content for the message

            return $this->addMessage($content, $type);
            // Add the message
        }

        throw new BadMethodCallException(
            "Method '{$method}' not found in " . __CLASS__
        );
        // Throw an exception detailing the missing method
    }
}
