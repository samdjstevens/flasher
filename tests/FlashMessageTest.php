<?php

use Spanky\Flasher\FlashMessage;

class TestClass {}
class TestClassWithToString { public function __toString() { return 'test'; }}

class FlashMesageTest extends PHPUnit_Framework_TestCase {

    /**
     * Test that the content can be set via 
     * the constructor method.
     */
    public function test_can_set_content_in_constructor() 
    {
        $message = new FlashMessage('My Test Message');
        $this->assertEquals('My Test Message', $message->getContent());
    }

    /**
     * Test that an exception is thrown if trying to
     * set an array as the content.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_content_with_array() 
    {
        $object = new FlashMessage(array(1, 2, 3));
    }

    /**
     * Test that an exception is thrown if trying to
     * set an integer as the content.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_content_with_integer() 
    {
        $object = new FlashMessage(10);
    }

    /**
     * Test that an exception is thrown if trying to
     * set a boolean as the content.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_content_with_boolean() 
    {
        $object = new FlashMessage(true);
    }

    /**
     * Test that an exception is thrown if trying to
     * set an object that doesn't implement __toString 
     * as the content.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_content_with_invalid_object() 
    {
        $obj = new TestClass;
        $object = new FlashMessage($obj);
    }

    /**
     * Test that an object can be set as the content
     * if it implements the __toString method.
     */
    public function test_can_set_content_with_valid_object() 
    {
        $obj = new TestClassWithToString;
        $object = new FlashMessage($obj);
        $this->assertEquals('test', $object->getContent());
    }

    /**
     * Test that the type can be set via 
     * the constructor method.
     */
    public function test_can_set_type_in_constructor() 
    {
        $message = new FlashMessage('My Test Message', 'warning');
        $this->assertEquals('warning', $message->getType());
    }

    /**
     * Test that an exception is thrown if trying to
     * set an array as the type.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_type_with_array() 
    {
        $object = new FlashMessage('My Test Message', array(1, 2, 3));
    }

    /**
     * Test that an exception is thrown if trying to
     * set an integer as the type.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_type_with_integer() 
    {
        $object = new FlashMessage('My Test Message', 10);
    }

    /**
     * Test that an exception is thrown if trying to
     * set a boolean as the type.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_type_with_boolean() 
    {
        $object = new FlashMessage('My Test Message', true);
    }

    /**
     * Test that an exception is thrown if trying to
     * set an object that doesn't implement __toString 
     * as the type.
     * 
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_type_with_invalid_object() 
    {
        $obj = new TestClass;
        $object = new FlashMessage('My Test Message', $obj);
    }

    /**
     * Test that an object can be set as the type
     * if it implements the __toString method.
     */
    public function test_can_set_type_with_valid_object() 
    {
        $obj = new TestClassWithToString;
        $object = new FlashMessage('My Test Message', $obj);
        $this->assertEquals('test', $object->getType());
    }

    /**
     * Test that if no type is supplied, it defaults
     * to 'default'.
     */
    public function test_no_type_defaults_to_default() 
    {
        $object = new FlashMessage('My Test Message');
        $this->assertEquals('default', $object->getType());
    }

    /**
     * Test that the object returns the content when
     * casted to a string.
     */
    public function test_returns_content_when_cast_to_string() 
    {
        $object = new FlashMessage('My Test Message');
        $this->assertEquals('My Test Message', (string) $object);
    }
}