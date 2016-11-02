<?php

namespace PhpSpec\Exception\Fracture;

use PhpSpec\Exception\Exception;
use PhpSpec\Exception\Fracture\PropertyNotFoundException;

/**
 * Class PropertyAnnotation
 * Base class for all other exceptions regarding annotations
 * @package PhpSpec\Exception\Fracture
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class Property extends Exception
{
    /**
     * The name of the missing annotation tag.
     * @var string
     * @access protected
     */
    private $annotationName;

    /**
     * The item under test 
     * (in this case a reflection of a class property)
     * @var \ReflectionProperty
     * @access protected
     */
    private $subject;

    /**
     * @var string
     * @access protected
     */
    private $propertyName;

    /**
     * PropertyAnnotationMissing constructor.
     * @param string $message
     * @param \ReflectionProperty $subject
     * @param string $annotationName
     */
    public function __construct(\ReflectionProperty $subject, string $annotationName, $message)
    {
        $this->subject = $subject;
        $this->propertyName = $subject->getName();
        $this->annotationName = $annotationName;
        parent::__construct($message);
    }

    /**
     * Get accessor for propertyName
     * @return string1
     */
    public function getPropertyName() : string
    {
        return $this->propertyName;
    }

    /**
     * Get accessor for subject
     * @return \ReflectionProperty
     */
    public function getSubject() : \ReflectionProperty
    {
        return $this->subject;
    }
    
    /**
     * Get accessor for the name of the missing annotation.
     * @return string
     */
    public function getAnnotationName() : string
    {
        return $this->annotationName;
    }
}