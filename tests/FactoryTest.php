<?php

use Spanky\Flasher\Factory;

class FactoryTest extends PHPUnit_Framework_TestCase {

    /**
     * Test that the factory creates an instance of
     * Spanky\Flasher\FlasherManager.
     */
    public function test_creates_object() 
    {
        $object = Factory::make();

        $this->assertInstanceOf('Spanky\Flasher\FlasherManager', $object);
    }

    /**
     * Test that the factory creates an instance of
     * Spanky\Flasher\FlasherManager when passed an 
     * implementation of Spanky\Flasher\MessageStore\MessageStoreInterface.
     */
    public function test_creates_object_with_message_store() 
    {
        $messageStoreMock = $this->getMock('Spanky\Flasher\MessageStore\MessageStoreInterface');
        // Mock an implementation of the MessageStoreInterface

        $object = Factory::make($messageStoreMock);

        $this->assertInstanceOf('Spanky\Flasher\FlasherManager', $object);
    }

    /**
     * Test that the factory passes an instance of 
     * Spanky\Flasher\MessageStore\SessionMessageStore as the
     * message store, if none supplied.
     */
    public function test_passes_instance_of_session_message_store_by_default() 
    {
        $object = Factory::make();

        $this->assertInstanceOf('Spanky\Flasher\MessageStore\SessionMessageStore', $object->getMessageStore());
    }
}