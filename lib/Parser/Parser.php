<?php

namespace Parser;

use Parser\Base\ParserException;

class Parser
{
    /**
     * the base namespace of all parser objects in a project
     * @var string
     */
    private $base_namespace;
    
    /**
     * instantiated parser objects
     * @var array
     */
    private $loaded_parsers;
    
    /**
     * @param string $base_namespace optional base namespace for project parser classes
     */
    public function __construct($base_namespace = null)
    {
        $this->base_namespace = $base_namespace;
    }

    /**
     * get($name) looks for classes in this order:
     *     <li>{base namespace}\$name</li>
     *     <li>Parser\$name</li>
     *     <li>{base namespace}\$name\$name.Parser</li>
     *     <li>Parser\$name\$name.Parser</li>
     * 
     * get($name, $type) looks for object-specific classes:
     *     <li>{base namespace}\$type\Objects\$name.Parser</li>
     * 
     * @param string $name
     * @param string $type = null
     * @throws ParserException
     * @return Parser\Base\ParserInterface
     */
    public function get($name, $type = null)
    {
        if (isset($this->loaded_parsers[$name])) 
            return $this->loaded_parsers[$name];
        
        if (isset($this->loaded_parsers[$type][$name])) 
            return $this->loaded_parsers[$type][$name];
        
        if (!$type) 
        {
            //look for primitive parser class
            if ($class = $this->getClass($name))
            {
                $this->loaded_parsers[$name] = $class;
                return $class;
            }

            //look for datatype parser, i.e. JSON\Base\JSONParser
            $typeName = $name . '\\' . $name . 'Parser';
            if ($class = $this->getClass($typeName))
            {
                $this->loaded_parsers[$name] = $class;
                return $class;
            }
        } 
        else 
        {
            //look for object-specific parser in project namespace
            $typeName = $this->base_namespace.'\\'.$type . '\\Objects\\' . $name . 'Parser';
            if (class_exists($typeName))
            {
                $this->loaded_parsers[$type][$name] = new $typeName;
                return $this->loaded_parsers[$type][$name];
            }
        }
        throw new ParserException($name . ' parser not found');
    }
    
    /**
     * returns instantiated class, first checks base_namespace, then Parser namespace
     * 
     * @param string $class
     * @return object|false
     */
    private function getClass($class)
    {
        //check for overide
        if ($this->base_namespace)
        {
            if (class_exists($this->base_namespace.'\\'.$class))
                return new $this->base_namespace.'\\'.$class;
        }  
        
        //check current namespace
        $nc = __NAMESPACE__.'\\'.$class;
        if (class_exists($nc))
            return new $nc;
        
        return false;
    }
    
    /**
     * @return string
     */
    public function getBaseNamespace()
    {
        return $this->base_namespace;
    }

    /**
     * @param string $base_namespace
     * @return \Parser\Parser
     */
    public function setBaseNamespace($base_namespace)
    {
        $this->base_namespace = $base_namespace;
        return $this;
    }
    
    /**
     * register spl autoload closure
     */
    public static function registerAutoload()
    {
        spl_autoload_register(function ($class) {
            $file = __DIR__.'/../' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($file)) require_once $file;
        });
    }
}
