<?php namespace Spanky\Flasher\Collections;

use IteratorAggregate;
use ArrayIterator;
use Countable;
use ArrayAccess;

abstract class AbstractCollection implements IteratorAggregate, ArrayAccess, Countable{

    /**
     * The items belonging to the collection.
     * 
     * @var array
     */
    private $items = array();

    /**
     * Accept an array of items and transform
     * them.
     * 
     * @param array $items
     */
    public function __construct($items = array()) 
    {
        $this->transformItems($items);
    }

    /**
     * Spin all the items through the
     * transform method.
     * 
     * @param  array $items
     */
    private function transformItems(array $items) 
    {
         $this->items = array_map(array(&$this, 'transform'), $items);
    }

    /**
     * Transform an item.
     * 
     * @param  array $item
     * @return mixed
     */
    abstract public function transform(array $item);

    /**
     * Get the first item in the collection.
     * 
     * @return mixed
     */
    public function first() 
    {
        $values = array_values($this->items);
        return array_shift($values);
    }

    /**
     * Get the last item in the collection.
     * 
     * @return mixed
     */
    public function last() 
    {
        return end($this->items);
    }

    /**
     * Get the iterator for the items.
     * 
     * @return ArrayIterator
     */
    public function getIterator() 
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Count the number of items in the 
     * collection.
     * 
     * @return integer
     */
    public function count() 
    {
        return count($this->items);
    }

    /**
     * Determine whether an item exists 
     * at an offset in the collection or 
     * not.
     * 
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) 
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Get an item at an offset in the collection.
     * 
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) 
    {
        return $this->items[$offset];
    }

    /**
     * Set an item at an offset in the collection.
     * 
     * @param  mixed $offset
     */
    public function offsetSet($offset, $value) 
    {
        if (is_null($offset)) 
        {
            array_push($this->items, $value);
        }
        else
        {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Unset an item at an offset in the collection.
     * 
     * @param  mixed $offset
     */
    public function offsetUnset($offset) 
    {
        unset($this->items[$offset]);
    }
}