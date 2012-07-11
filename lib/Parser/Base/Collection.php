<?php

namespace Parser\Base;

class Collection
implements \Iterator, \Countable
{
    /**
     * array position
     * @var integer
     */
    private $position = 0;
    
    /**
     * @var array $collection
     */
    protected $collection = array();
    
    
    /**
     * @param mixed $item
     * @return \Parser\Base\Collection
     */
    public function addItem($item)
    {
        $this->collection[] = $item;
        
        return $this;
    }
    
    /**
     * @param array $collection
     * @return \Parser\Base\Collection
     */
    public function setCollection(array $collection)
    {
        $this->collection = $collection;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getCollection()
    {
        return $this->collection;
    }
    
    /**
     * (non-PHPdoc)
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->position = 0;
    }
    
    /**
     * (non-PHPdoc)
     * @see Iterator::current()
     *
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->position];
    }
    
    /**
     * (non-PHPdoc)
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->position;
    }
    
    /**
     * (non-PHPdoc)
     * @see Iterator::next()
     */
    public function next()
    {
        ++$this->position;
    }
    
    /**
     * (non-PHPdoc)
     * @see Iterator::valid()
     */
    public function valid()
    {
        return isset($this->collection[$this->position]);
    }
    
    /**
     * (non-PHPdoc)
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->collection);
    }
}