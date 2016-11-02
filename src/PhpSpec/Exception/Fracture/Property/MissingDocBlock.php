<?php

namespace PhpSpec\Exception\Fracture\Property;



use PhpSpec\Exception\Fracture\PropertyNotFoundException;

/**
 * Class MissingDocBlock
 * Exception to raise when documentation block is missing from a class property
 * @package PhpSpec\Exception\Fracture\Property
 */
class MissingDocBlock extends PropertyNotFoundException
{
    /**
     * MissingDocBlock constructor.
     * @param \ReflectionProperty $subject
     * @param null $message Override the default message
     */
    public function __construct(\ReflectionProperty $subject, $message = null)
    {
        $propName  = $subject->getName();
        $className = $subject->getDeclaringClass()->getName();

        // default message
        $message = $message ?? "Missing documentation block (aka DocBlock or DocComment) that was expected for property "
            . "{$propName} in class {$className}";

        //Populate other params in parent 
        parent::__construct($message,
            $subject->getDeclaringClass()->newInstanceWithoutConstructor(), // reconstitute $subject
            $subject->getName()
        );
    }
}