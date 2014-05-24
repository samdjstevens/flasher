<?php namespace Spanky\Flasher;

class FlashMessage {

    /**
     * The message content.
     * 
     * @var string
     */
    private $content;

    /**
     * The message type.
     * 
     * @var string
     */
    private $type;

    /**
     * Give the message it's properties.
     * 
     * @param string $content
     * @param string $type
     */
    public function __construct($content, $type) 
    {
        $this->content = $content;
        $this->type = $type;
    }

    /**
     * Get the message content.
     * 
     * @return string
     */
    public function getContent() 
    {
        return $this->content;
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
        return $this->getContent();
    }
}