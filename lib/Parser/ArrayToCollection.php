<?php

namespace Parser;

use Parser\Base\ParserInterface;

class ArrayToCollection
implements ParserInterface
{ 
    /**
     * @param array $input
     * @param array $options array('class_name' => $name)
     * @return Collection
     */
    public function getOutput($input, array $options = array()) 
    {
        $ato = new ArrayToObject();
        $class = $options['class_name'].'Collection';
        
        $collection = new $class;
        
        foreach ($input as $objectArray)
        {
            $collection->addItem($ato->getOutput($objectArray, $options));
        }
        
        return $collection;
    }

}