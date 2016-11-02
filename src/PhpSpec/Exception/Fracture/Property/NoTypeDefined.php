<?php

namespace PhpSpec\Exception\Fracture;


use PhpSpec\Exception\Exception;

/**
 * Class NoTypeDefined
 * Exception to throw if no datatype was defined in the docBlock
 * @package PhpSpec\Exception\Fracture
 */
class NoTypeDefined extends Property
{
    protected $subject;
    protected $propertyName;
    protected $dataTypeExpected;
    protected $dataTypeFound;


    /**
     * NoTypeDefined constructor.
     * @param \ReflectionProperty $subject
     * @param string $dataTypeExpected
     * @param null $message
     */
    public function __construct(\ReflectionProperty $subject, string $dataTypeExpected, $message = null)
    {
        $this->subject = $subject;
        $this->propertyName = $subject->getName();
        $this->dataTypeExpected = $dataTypeExpected;
        
        $message = $message ?? "Property {$this->propertyName} is not expected type {$dataTypeExpected}, no datatype annotation "
            . "(@var) was found";
        
        parent::__construct($subject, 'var', $message);
    }

    /**
     * @return string
     */
    public function getPropertyName() : string
    { 
        return $this->propertyName;
    }

    /**
     * @return \ReflectionProperty
     */
    public function getSubject() : \ReflectionProperty
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getDataTypeExpected() : string
    {
        return $this->dataTypeExpected;
    }
    

}