<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-07-04 at 16:05:09.
 */
use Parser\TestObjects\TestObjectCollection;
use Parser\TestObjects\TestObject;

class Parser_Tests_JSON_JSONParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Parser\JSON\JSONParser
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Parser\JSON\JSONParser;
        
        $obj = new stdClass();
        $obj->one = 1;
        $obj->two = new stdClass();
        $obj->two->one = 1;
        $this->unencoded = array('one', 'two', $obj);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Parser\JSON\JSONParser::jsonEncode
     */
    public function testJsonEncode()
    {
        $json = $this->object->jsonEncode($this->unencoded);
        
        $this->assertEquals('["one","two",{"one":1,"two":{"one":1}}]', $json);
        
        return $json;
    }

    /**
     * @covers Parser\JSON\JSONParser::jsonDecode
     * @depends testJsonEncode
     */
    public function testJsonDecode($json)
    {
        $this->assertEquals($this->unencoded, $this->object->jsonDecode($json));
        
        $this->setExpectedException('\\Parser\\Base\\ParserException', 'JSON decoder failed');
        $this->object->jsonDecode('{"bad json}}');
    }

    /**
     * @covers Parser\JSON\JSONParser::arrayToObject
     * @todo   Implement testArrayToObject().
     */
    public function testArrayToObject()
    {
        //no recursion
        $testArray = array(
                    'first_property'  => 1,
                    'second_property' => 2
                );
        $actual = $this->object->arrayToObject($testArray, '\\Parser\\TestObjects\\TestObject');
        
        $testObject = new TestObject();
        $testObject
            ->setFirstProperty(1)
            ->setSecondProperty(2);
        
        $this->assertEquals($testObject, $actual);
        
        //with recursion
        $testObjectTwo = new TestObject();
        $testObjectTwo
            ->setFirstProperty(3)
            ->setSecondProperty(4);
        
        $collection = new TestObjectCollection();
        $collection
            ->addItem($testObject)
            ->addItem($testObjectTwo);
        
        $testObjectThree = new TestObject();
        $testObjectThree
            ->setFirstProperty('string')
            ->setSecondProperty('another string')
            ->setTestObjects($collection);
        
        $testArray = array(
            'first_property'  => 'string',
            'second_property' => 'another string',
            'test_objects' => array(
                 array(
                    'first_property'  => 1,
                    'second_property' => 2
                 ),
                 array(
                     'first_property'  => 3,
                     'second_property' => 4
                 )
             )
        );
        
        $actual = $this->object->arrayToObject($testArray, '\\Parser\\TestObjects\\TestObject', array(
            'child_namespaces' => array(
                'test_objects' => '\\Parser\\TestObjects'
            )
        ));
        
        $this->assertEquals($testObjectThree, $actual);
    }

    /**
     * @covers Parser\JSON\JSONParser::arrayToCollection
     */
    public function testArrayToCollection()
    {
        $testObject = new TestObject();
        $testObject
            ->setFirstProperty(1)
            ->setSecondProperty(2);
        
        $testObjectTwo = new TestObject();
        $testObjectTwo
            ->setFirstProperty(3)
            ->setSecondProperty(4);
        
        $collection = new TestObjectCollection();
        $collection
            ->addItem($testObject)
            ->addItem($testObjectTwo);
        
        $testArray = array(
            array(
                    'first_property'  => 1,
                    'second_property' => 2
            ),
            array(
                    'first_property'  => 3,
                    'second_property' => 4
            )
        );
        
        $actual = $this->object->arrayToCollection($testArray, '\\Parser\\TestObjects\\TestObject');
        
        $this->assertEquals($collection, $actual);
    }
}