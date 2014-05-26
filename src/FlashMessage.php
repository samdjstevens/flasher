<?php namespace Spanky\Flasher;

use InvalidArgumentException;

class FlashMessage {

    /**
     * The message content.
     * 
     * @var string
     */
    protected $content;

    /**
     * The message type.
     * 
     * @var string
     */
    protected $type;

    /**
     * Give the message it's properties.
     * 
     * @param string $content
     * @param string $type
     */
    public function __construct($content, $type = null) 
    {
        $this->setContent($content);
        $this->setType($type);
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
     * Set the message content.
     * 
     * @param mixed $content
     */
    public function setContent($content) 
    {
        $content = $this->validateContent($content);

        $this->content = $content;
    }

    /**
     * Get the message type.
     * 
     * @return string
     */
    public function getType() 
    {
        return $this->type;
    }

    /**
     * Set the message type.
     * 
     * @param string $type
     */
    public function setType($type) 
    {
        $type = $this->validateType($type);

        $this->type = $type;
    }

    /**
     * Validate the content.
     * 
     * @param  mixed $content
     * @return string
     */
    protected function validateContent($content) 
    {
        if (! is_string($content) and ! (is_object($content) and method_exists($content, '__toString'))) 
        {
            throw new InvalidArgumentException(
                "Content must be of type string, or implement the __toString method."
            );
        }
        // Ensure the content is either a string, or an
        // object that implements the __toString method

        return (string) $content;
        // Cast to string if an object
    }

    /**
     * Validate the type.
     * 
     * @param  mixed $type
     * @return string
     */
    protected function validateType($type) 
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
        // Ensure the type is either a string, or an
        // object that implements the __toString method

        return (string) $type;
        // Cast to string if an object
    }

    /**
     * Return the content when
     * the object is casted to a string.
     * 
     * @return string
     */
    public function __toString() 
    {
        return $this->getContent();
    }
}