<?php

namespace PhpSpec\Matcher\Property\Annotations\Doctrine;

use PhpSpec\Exception\Fracture\Invalid;
use PhpSpec\Matcher\Matcher;
use PhpSpec\Matcher\Property\Annotations\Doctrine;

/**
 * Class BeType
 * Implements the matchers shouldHaveDoctrineColName() and shouldBeDoctrineType()
 * Handles checking on annotations under \ORM\Column tag
 * @package PhpSpec\Matcher\Property\Annotations\Doctrine
 */
class BeType extends Doctrine
{
    public function negativeMatch($name, $subject, array $arguments)
    {
        // TODO: Implement negativeMatch() method.
    }

    public function getPriority()
    {
        // TODO: Implement getPriority() method.
    }

    public function positiveMatch($name, $subject, array $arguments)
    {
        // TODO: Implement positiveMatch() method.
    }

    /**
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     * @return bool
     */
    public function supports($name, $subject, array $arguments)
    {
        return $name == 'beDoctrineType' || $name == 'haveDoctrineColName';
    }

    /**
     * @param $name
     * @param \ReflectionProperty $subject
     * @param array $arguments
     * @return \ReflectionParameter
     * @throws \PhpSpec\Exception\Fracture\AnnotationMissing
     */
    public function match($name, $subject, array $arguments) 
    {
        // Parse the annotation desc ("key"="val"...) into an array like [key=>val]
        $tag = $this->getTagObject($subject,'Column');
        $found = $this->getArgsAsArray($tag->getDescription());

        // determine what we are looking *for*
        $key = ($name == 'beDoctrineType') ? 'type' : 'name';

        // get the tag object from the class annotation (throws exception  if ! tag exist)
        if ($arguments[0] != $found[$key])
            throw new Invalid("Doctrine datatype or field name is incorrect, expecting {$arguments[0]}"
            . " but found {$found[$key]} check the @ORM\\Column annotation on property " . $subject->getName()
                . ' in class ' . $subject->getDeclaringClass()->getName(),
                $subject, $subject->getName(), 'ORM\Column', $found[$key], $found[$key]);

        return $subject;
    }

}
    
