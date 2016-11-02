<?php

namespace PhpSpec\Matcher\Property\Annotations\Doctrine;


use PhpSpec\Exception\Fracture\Property\Annotation\Invalid;
use PhpSpec\Exception\Fracture\Property\Annotation\Missing;
use PhpSpec\Matcher\Property\Annotations\Doctrine;

/**
 * Class HasCustomGenerator
 * Implements the matcher shouldHaveDoctrineCustomGenerator()
 * @package PhpSpec\Matcher\Property\Annotations\Doctrine
 */
class HasCustomGenerator extends Doctrine
{

    public function getPriority()
    {
        // TODO: Implement getPriority() method.
    }

    public function negativeMatch($name, $subject, array $arguments)
    {
        // TODO: Implement negativeMatch() method.
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
        return $name == 'haveDoctrineCustomGenerator';
    }

    /**
     * @param $name
     * @param \ReflectionProperty $subject
     * @param array $arguments
     * @return \ReflectionProperty
     * @throws Invalid
     * @throws Missing
     * @throws \Exception
     * @throws \PhpSpec\Exception\Fracture\AnnotationMissing
     */
    public function match($name, \ReflectionProperty $subject, array $arguments) : \ReflectionProperty
    {
        $tagName = 'ORM\CustomIdGenerator';

        $docBlock = $this->getTagObject($tagName);
        if (! is_object($docBlock) || count($docBlock) == 0 )
            throw new Missing(null, $subject, $subject->getName(), $tagName);
        $desc = $docBlock->getDescription();
        if ( $this->isArgsMismatch($desc, $arguments[0]) )
            throw new Invalid('Doctrine CustomIDGenerator class invalid, check annotations of property '
                . $subject->getName() . ' in class ' . $subject->getDeclaringClass()->getName() 
                . ' expecting ' . $arguments[0]['class'] . ' but found ' .  $desc, $subject, $subject->getName(),
                $tagName, $arguments[0]['class'], $desc);
    }
}
