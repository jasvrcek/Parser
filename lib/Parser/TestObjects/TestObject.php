<?php
namespace Parser\TestObjects;
class TestObject
{
    private $first_property;

    private $second_property;

    private $test_objects;

    /**
     * @return the unknown_type
     */
    public function getFirstProperty()
    {
        return $this->first_property;
    }

    /**
     * @param unknown_type $first_property
     * @return TestObject
     */
    public function setFirstProperty($first_property)
    {
        $this->first_property = $first_property;
        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getSecondProperty()
    {
        return $this->second_property;
    }

    /**
     * @param unknown_type $second_property
     * @return TestObject
     */
    public function setSecondProperty($second_property)
    {
        $this->second_property = $second_property;
        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getTestObjects()
    {
        return $this->test_objects;
    }

    /**
     * @param unknown_type $array_to_collection_test_objects
     * @return TestObject
     */
    public function setTestObjects($test_objects)
    {
        $this->test_objects = $test_objects;
        return $this;
    }

}
