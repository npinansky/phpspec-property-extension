<?php

namespace PhpSpec\Exception\Fracture\Property;
use PhpSpec\Exception\Fracture\PropertyNotFoundException;

/**
 * Exception thrown when a property exists but is of the wrong access type
 * Class PropertyInvalidAccess
 * @package PhpSpec\Exception\Fracture
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class InvalidAccess extends PropertyNotFoundException
{
    /**
     * @var string
     * @access private
     */
    private $propertyAccessType;

    /**
     * PropertyInvalidAccess constructor.
     * @param string $message
     * @param mixed $subject
     * @param string $property
     * @param string $propertyAccessType
     */
    public function __construct($message, $subject, $property, string $propertyAccessType)
    {
        $this->propertyAccessType = $propertyAccessType;

        // Set default message if nothing set
        $message = $message ?? "Property {$property} should be {$propertyAccessType}ly accessible";
        parent::__construct($message, $subject, $property);
    }

    /**
     * Accessor for the access type
     * @return string
     */
    public function getAccessType() : string
    {
        return $this->propertyAccessType;
    }
}