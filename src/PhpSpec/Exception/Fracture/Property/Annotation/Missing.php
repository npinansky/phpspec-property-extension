<?php

namespace PhpSpec\Exception\Fracture\Property\Annotation;

use PhpSpec\Exception\Exception;
use PhpSpec\Exception\Fracture\Property;
use PhpSpec\Exception\Fracture\PropertyNotFoundException;

/**
 * Class PropertyAnnotationMissing
 * Exception thrown when an annotation that was expected was not found
 * @package PhpSpec\Exception\Fracture
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class Missing extends Property
{

    /**
     * PropertyAnnotationMissing constructor.
     * @param string $message
     * @param \ReflectionProperty $subject
     * @param string $annotationName
     */
    public function __construct(\ReflectionProperty $subject, string $annotationName, $message = null)
    {
        $className = $subject->getDeclaringClass()->getName();
        $propertyName = $subject->getName();

        $message = $message ?? "An annotation named @{$annotationName} was expected but not found. "
            . "It was expected on the property {$propertyName} of the class {$className}";

        parent::__construct($subject,$annotationName, $message);
    }
    
}