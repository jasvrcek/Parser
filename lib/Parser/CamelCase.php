<?php

namespace Parser;

use Parser\Base\ParserInterface;

class CamelCase
implements ParserInterface
{
    /**
     * @param string $input
     * @param array $options
     * @return string
     */
    public function getOutput($input, array $options = array())
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $input)));
    }
}