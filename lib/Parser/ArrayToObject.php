<?php

namespace Parser;

use Parser\Base\ParserInterface;
use Parser\Base\ParserException;

class ArrayToObject
implements ParserInterface
{ 
    /** 
     * @param array $input
     * @param array $options array('class_name' => $name, 'child_namespaces' = array('property' => 'namespace')
     * @return object
     */
    public function getOutput($input, array $options = array()) 
    {
        if (!is_array($input))
            throw new ParserException('Input must be an array');
        
        $atc = new ArrayToCollection();
        $cc = new CamelCase();
        
        $class = $options['class_name'];
        
        if (!class_exists($class))
            throw new ParserException('Class not found: '.$class);
        
        $object = new $class;
        
        foreach ($input as $property => $value)
        {
            $method = 'set'.$cc->getOutput($property);
            
            if (is_array($value))
            {
                //if property is new object
                if (class_exists($this->getNamespace($property, $options).$cc->getOutput($property))) 
                {
                    $opt = $options;
                    $opt['class_name'] = $cc->getOutput($property);
                    $value = $this->getOutput($value, $opt);
                    unset($opt);
                }
                
                //test if property is collection
                $collectionObjectName = $this->getNamespace($property, $options).$cc->getOutput(substr($property, 0, -1));
                
                if (class_exists($collectionObjectName.'Collection')) 
                {
                    $opt = $options;
                    $opt['class_name'] = $collectionObjectName;
                    $value = $atc->getOutput($value, $opt);
                    unset($opt);
                }
            }
            
            $object->$method($value);
        }
        
        return $object;
    }
    
    /**
     * @param string $property
     * @param array $options
     * @return string
     */
    private function getNamespace($property, array $options)
    {
        if (isset($options['child_namespaces'][$property]))
        {
            return $options['child_namespaces'][$property].'\\';
        }
        return '\\';
    }

}