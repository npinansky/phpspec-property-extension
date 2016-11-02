<?php

namespace PhpSpec\Matcher\Property\Annotations\Doctrine;

use PhpSpec\Matcher\Property\Annotations\Doctrine;

/**
 * Class HaveIdField
 * Implements shouldBeDoctrineIdField()
 * @package PhpSpec\Matcher\Property\Annotations\Doctrine
 */
class BeIdField extends Doctrine
{

    public function getPriority()
    {
        // TODO: Implement getPriority() method.
    }

    public function positiveMatch($name, $subject, array $arguments)
    {
        // TODO: Implement positiveMatch() method.
    }

    public function negativeMatch($name, $subject, array $arguments)
    {
        // TODO: Implement negativeMatch() method.
    }

    public function supports($name, $subject, array $arguments)
    {
        // TODO: Implement supports() method.
    }

    public function match($name, \ReflectionProperty $subject, array $arguments) : \ReflectionProperty
    {
        // TODO: Implement match() method.
    }
}