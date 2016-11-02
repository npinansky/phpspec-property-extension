<?php

namespace PhpSpec\Exception\Fracture\Property;


use PhpSpec\Exception\Fracture\ComparisonException;
use PhpSpec\Exception\Fracture\Property;

/**
 * Class WrongType
 * Exception to throw if datatype in dockBlock @var annotation doesnt match expectation
 * @package PhpSpec\Exception\Fracture\Property
 */
class WrongType extends Property implements ComparisonException
{
    protected $subject;
    protected $propertyName;
    protected $expected;
    protected $found;

    /**
     * WrongType constructor.
     * @param \ReflectionProperty $subject
     * @param string $dataTypeExpected
     * @param string $dataTypeFound
     * @param null|string $message
     */
    public function __construct(\ReflectionProperty $subject, string $dataTypeExpected, string $dataTypeFound, $message = null)
    {
        $this->subject = $subject;
        $propertyName = $this->propertyName = $subject->getName();
        $this->dataTypeExpected = $dataTypeExpected;
        $this->dataTypeFound = $dataTypeFound;
        
        $message = $message ?? "Property {$propertyName} is not expected type {$dataTypeExpected}, instead type "
           . " {$dataTypeFound} was found";
        
        parent::__construct($subject, $propertyName, $message);
    }

    /**
     * Get the data type that was expected (as defined in spec)
     * @return string
     */
    public function getExpected() : string
    {
        return $this->expected;
    }

    /**
     * Get the data type that was found (defined in the class)
     * @return string
     */
    public function getFound() : string
    {
        return $this->found;
    }

}