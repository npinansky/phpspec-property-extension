<?php

namespace PhpSpec\Exception\Fracture\Property\Annotation;


use PhpSpec\Exception\Fracture\Property;

/**
 * Class TooMany
 * Exception thrown when there are a different number of annotations in the DocBlock with a given name than
 * we actually expected.
 *
 * @package PhpSpec\Exception\Fracture\Property\Annotation
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class TooMany extends Property
{

    /**
     * @var int $found Number of annotations found in DocBlock with same name
     * @access private
     */
    private $found;

    /**
     * @var int $expected Number of annotations expected in DocBlock with the same name
     * @access private
     */
    private $expected;

    /**
     * TooMany constructor.
     * @param \ReflectionProperty $subject
     * @param string $annotationName Name of the annotation / @ tag.
     * @param int $expected Number of annotations expected in block comment with annotationName
     * @param int $found Number of annotations found in block comment with annotationName
     * @param null $message Override the defaulterrorstring.-
     */
    public function __construct(\ReflectionProperty $subject, $annotationName,  int $expected = 1, int $found,
                                $message = null)
    {
        $this->expected = $expected;
        $this->found = $found;

        $propName = $subject->getName();
        $className = $subject->getDeclaringClass()->getName();
        $message = $message ?? "Property {$propName} in class {$className} has too many annotations named "
            . "@{$annotationName}";
             
        parent::__construct($subject, $annotationName, $message);
    }

    public function getExpected() : int
    {
        return $this->found;
    }

    public function getFound() : int
    {
        return $this->expected;
    }
}