<?php

namespace Parser\JSON;

use Parser\ArrayToCollection;
use Parser\ArrayToObject;
use Parser\Base\Collection;
use Parser\Base\ParserException;

class JSONParser
{
    /**
     * @param string $input
     * @param integer $options Bitmask of json options
     * @return string
     */
    public function jsonEncode($input, $options = 0)
    {
        return json_encode($input, $options);
    }
    
    /**
     * @param string $json
     * @param boolean $assoc = false
     * @return mixed
     */
    public function jsonDecode($json, $assoc = false)
    {
        $result = json_decode($json, $assoc);
        
        if ($result === null && $json)
        {
            switch (json_last_error())
            {
                case JSON_ERROR_NONE:
                    $error = 'No error has occurred';
                    break;

                case JSON_ERROR_DEPTH:
                    $error = 'The maximum stack depth has been exceeded';
                    break;

                case JSON_ERROR_STATE_MISMATCH:
                    $error = 'Invalid or malformed JSON';
                    break;

                case JSON_ERROR_CTRL_CHAR:
                    $error = 'Control character error, possibly incorrectly encoded';
                    break;

                case JSON_ERROR_SYNTAX:
                    $error = 'Syntax error';
                    break;

                case JSON_ERROR_UTF8:
                    $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
            }
                
            throw new ParserException('JSON decoder failed: '.$error);
        }
        
        return $result;
    }
    
    /**
     * @param array $array
     * @param string $class
     * @param array $options = array()
     * @return object
     */
    public function jsonToObject($json, $class, $options = array())
    {
        $options = array_merge(array('class_name' => $class), $options);
        $ato = new ArrayToObject();
        $array = $this->jsonDecode($json, true);
        return $ato->getOutput($array, $options);
    }
    
    /**
     * @param array $json
     * @param string $class
     * @param array $options = array()
     * @return object
     */
    public function jsonToCollection($json, $class, $options = array())
    {
        $options = array_merge(array('class_name' => $class), $options);
        $atc = new ArrayToCollection();
        $array = $this->jsonDecode($json, true);
        return $atc->getOutput($array, $options);
    }
}