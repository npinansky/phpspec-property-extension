<?php

namespace PhpSpec\Exception\Fracture\Property\Annotation;
use PhpSpec\Exception\Fracture\ComparisonException;
use PhpSpec\Exception\Fracture\Property;


/**
 * A DocBlock annotation (@ / tag) was found, but the value did not match what was expected
 * Class Invalid
 * @package PhpSpec\Exception\Fracture
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class Invalid extends Property implements ComparisonException
{
    /**
     * @var string
     */
    private $valueExpected;

    /**
     * @var string
     */
    private $valueFound;

    /**
     * Invalid Exception constructor.
     * @param \ReflectionProperty $subject A reflection of the object under test
     * @param string $annotationName The name of the annotation (tag) under test
     * @param string $valueExpected
     * @param string $valueFound
     * @param null $message
     */
    public function __construct(\ReflectionProperty $subject, string $annotationName, string $valueExpected,
                                string $valueFound, $message = null)
    {
        $property = $subject->getName();
        $this->valueExpected  = $valueExpected;
        $this->valueFound     = $valueFound;
        
        $message = $message ?? "Property {$property} has invalid annotation (tag) value on {$annotationName}"
            . " expected value: {$valueExpected} but found: {$valueFound}";
        
        parent::__construct($subject,$annotationName, $message);
    }
    
    public function getExpected() : string
    {
        return $this->valueExpected;
    }
    
    public function getFound() : string
    {
        return $this->valueFound;
    }
}