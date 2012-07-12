Parser
======

php library for parsing/converting data

Usage
-----

Basic usage. Autoloader is optional.
```php
//require 'Parser/Parser.php';
//Parser::registerAutoload();

$cp = new \Parser\CamelCase();

$stringConvertedToCamelCase = $cp->getOutput('my_example_string');
```

Optional factory:
```php
$p = new \Parser\Parser();

$string = $p->get('CamelCase')->getOutput('example string');
```


You can add custom parsers in your project, override existing ones. 
The following example will load \MyProject\Parsers\JSON\Object\MyCustomObjectParser to convert the json string into an instance of MyCustomObject.
```php
$p = new \Parser\Parser('\\MyProject\\Parsers');

$myCustomObjectInstance = $p->get('MyCustomObjectParser', 'JSON')->getOutput('{ "a_property": "example string" }');
```
The above example could actually use the included "JSONParser":

```php
$json = '{ "a_property": "example string" }';
$myCustomObjectInstance = $p->get('JSON')->jsonToObject($json, '\\MyProject\\Objects\\MyCustomObject');
```

Included Parsers
----------------

__Parser\CamelCase:__ convert strings to camel case ```$p->get('CamelCase')```

__Parser\ArrayToObject:__ convert array to instance of given class (class must have setter methods for all public properties) ```$p->get('ArrayToObject')```

__Parser\ArrayToCollection:__ convert array to collection of objects (collection must extend Parser\Base\Collection) ```$p->get('ArrayToCollection')```

__Parser\JSON\JSONParser:__ converts json to instance of given class or collection class, etc. ```$p->get('JSON')```