<?php

use Spanky\Flasher\FlasherManager;
use Spanky\Flasher\FlashMessage;

class FlasherManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the ability to create an instance of the FlasherManager.
     */
    public function test_can_create_object() 
    {
         $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        // Mock an implementation of the MessageStoreInterface

        $flasherManager = new FlasherManager($messageStoreMock);

        $this->assertInstanceOf('Spanky\Flasher\FlasherManager', $flasherManager);
    }

    /**
     * Test that adding a message calls the add function
     * on the message store.
     */
    public function test_can_add_message() 
    {
        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        $messageStoreMock
            ->expects($this->once())
            ->method('add')
            ->with($this->equalTo(new FlashMessage('My Test Message', 'success')));

        $flasherManager = new FlasherManager($messageStoreMock);
        $flasherManager->addMessage('My Test Message', 'success');
    }

    /**
     * Test that it triggers getAll on the message store 
     * and hasMessages returns true after adding
     * a message.
     */
    public function test_has_messages_after_add() 
    {
        $messages = array(
            array(
                'content' => 'My Test Message',
                'type' => 'success'
            )
        );

        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        $messageStoreMock
            ->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue($messages));

        $flasherManager = new FlasherManager($messageStoreMock);
        $flasherManager->addMessage('My Test Message', 'success');

        $this->assertTrue($flasherManager->hasMessages());
    }

    /**
     * Test that it triggers getAllByType('[type]') on the message store 
     * and hasMessages('[type]') returns true after adding
     * a message.
     */
    public function test_has_messages_of_type_after_add() 
    {
        $messages = array(
            array(
                'content' => 'My Test Message',
                'type' => 'danger'
            )
        );

        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        $messageStoreMock
            ->expects($this->once())
            ->method('getAllByType')
            ->with($this->equalTo('danger'))
            ->will($this->returnValue($messages));

        $flasherManager = new FlasherManager($messageStoreMock);
        $flasherManager->addMessage('My Test Message', 'success');

        $this->assertTrue($flasherManager->hasMessages('danger'));
    }

    /**
     * Test that getMessages returns an instance of 
     * Spanky\Flasher\Collections\MessageCollection 
     * containing an array of FlashMessage objects.
     */
    public function test_can_get_all_messages() 
    {
        $messages = array(new FlashMessage('My Test Message', 'success'));

        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        $messageStoreMock
            ->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue($messages));

        $flasherManager = new FlasherManager($messageStoreMock);
        $flasherManager->addMessage('My Test Message', 'success');

        $returnedMessages = $flasherManager->getMessages();

        $this->assertInstanceOf('Spanky\Flasher\Collections\MessageCollection', $returnedMessages);
        $this->assertEquals($messages, $returnedMessages->all());
    }

    /**
     * Test that getMessages('[type]') returns an instance of 
     * Spanky\Flasher\Collections\MessageCollection 
     * containing an array of FlashMessage objects with that
     * type.
     */
    public function test_can_get_all_messages_of_type() 
    {
        $messages = array(
            new FlashMessage('My Test Success Message', 'success')
        );

        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        $messageStoreMock
            ->expects($this->once())
            ->method('getAllByType')
            ->with($this->equalTo('success'))
            ->will($this->returnValue($messages));

        $flasherManager = new FlasherManager($messageStoreMock);
        $flasherManager->addMessage('My Test Success Message', 'success');
        $flasherManager->addMessage('My Test Error Message', 'error');
        $flasherManager->addMessage('My Test Danger Message', 'danger');

        $returnedMessages = $flasherManager->getMessages('success');

        $this->assertInstanceOf('Spanky\Flasher\Collections\MessageCollection', $returnedMessages);
        $this->assertEquals($messages, $returnedMessages->all());
    }


    /**
     * Test the ability to add a message of a certain type
     * by calling add[Type].
     */
    public function test_magic_add_method() 
    {
        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        $messageStoreMock
            ->expects($this->once())
            ->method('add')
            ->with($this->equalTo(new FlashMessage('My Test Message', 'success')));

        $flasherManager = new FlasherManager($messageStoreMock);
        $flasherManager->addSuccess('My Test Message');
    }

    /**
     * Test that a BadMethodCallException exception is thrown
     * when calling a missing method that doesn't start
     * with "add".
     * 
     * @expectedException BadMethodCallException
     */
    public function test_bad_method_call_exception_thrown_for_missing_methods() 
    {
        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        $flasherManager = new FlasherManager($messageStoreMock);
        $flasherManager->thisMethodDoesNotExist();
    }
}