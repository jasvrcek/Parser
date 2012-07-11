<?php

namespace Parser\Base;

interface ParserInterface
{
    public function getOutput($input, array $options = array());
}