<?php namespace Spanky\Flasher\MessageStore;

use Illuminate\Session\SessionManager;
use Spanky\Flasher\FlashMessage;

class LaravelSessionMessageStore implements MessageStoreInterface {

    /**
     * The Laravel SessionManager.
     * 
     * @var Illuminate\Session\SessionManager
     */
    protected $session;

    /**
     * The key to store the messages under in 
     * the session.
     * 
     * @var string
     */
    protected $sessionKey = 'spanky.flasher.messages';

    /**
     * The messages in the store.
     * 
     * @var array
     */
    protected $messages = array();

    /**
     * Inject the Laravel SessionManager and load the 
     * messages in from the session when instantiated.
     */
    public function __construct(SessionManager $session) 
    {
        $this->session = $session;
        $this->loadMessages();
    }

    /**
     * Load in previously set messages from
     * the session.
     */
    protected function loadMessages() 
    {
        if ($this->session->has($this->sessionKey)) 
        {
            $this->messages = $this->session->get($this->sessionKey);
        }
    }

    /**
     * Add a message into the store.
     * 
     * @param Spanky\Flasher\FlashMessage $message
     */
    public function add(FlashMessage $message) 
    {
        array_push($this->messages, $message);
        // Add it to the internal array

        $this->session->flash($this->sessionKey, $this->messages); 
        // Flash to session for next page load
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