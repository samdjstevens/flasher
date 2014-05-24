<?php namespace Spanky\Flasher;

class FlashMessage {

    /**
     * The message string.
     * 
     * @var string
     */
    private $message;

    /**
     * The message type.
     * 
     * @var string
     */
    private $type;

    /**
     * Give the message it's properties.
     * 
     * @param string $message
     * @param string $type
     */
    public function __construct($message, $type) 
    {
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Get the message string.
     * 
     * @return string
     */
    public function getMessage() 
    {
        return $this->message;
    }

    /**
     * Get the type string.
     * 
     * @return string
     */
    public function getType() 
    {
        return $this->type;
    }

    /**
     * Return the message string when
     * the object is casted to a string.
     * 
     * @return string
     */
    public function __toString() 
    {
        return $this->getMessage();
    }
}