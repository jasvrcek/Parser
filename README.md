Parser
======

php library for parsing/converting data

Usage
-----

```php

//optionally use included autoloader
Parser::registerAutoload();

$cp = new \Parser\CamelCase();

$stringConvertedToCamelCase = $cp->getOutput('my_example_string');

//optional factory
$p = new \Parser\Parser();

$string = $p->get('CamelCase')->getOutput('example string');

//add parsers in your project, override existing ones
$p = new \Parser\Parser('\\MyProject\\Parsers');

//get custom parser (must implement \Parser\ParserInterface)
$string = $p->get('MyJsonToObjectParser', 'JSON')->getOutput('{ "a_property": "example string" }');
```