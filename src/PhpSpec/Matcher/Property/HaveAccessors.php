<?php

namespace PhpSpec\Matcher\Property;


use PhpSpec\Exception\Fracture\Property\AccessorReturnedWrongType;
use PhpSpec\Exception\Fracture\Property\InvalidAccess;
use PhpSpec\Exception\Fracture\Property\WrongType;
use PhpSpec\Matcher\MatcherInterface;

/**
 * Class HaveAccessors
 * Make sure the class has get/set accessors for properties
 * @package PhpSpec\Matcher\Property
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class HaveAccessors implements MatcherInterface
{
    public function getPriority()
    {
        return 100;
    }

    public function supports($name, $subject, array $arguments)
    {
        return $name == 'haveAccessorsFor';
    }

    public function positiveMatch($name, $subject, array $arguments)
    {
        list($propertyName, $returnTypeExpected) = $arguments;

        $accessors = ['get' . ucfirst($propertyName), 'set' . ucfirst($propertyName)];

        $refClass = new \ReflectionClass($subject);

        try {
            foreach ($accessors as $accessor) {
                $refMethod = $refClass->getMethod($accessor);

                if (! $refMethod->isPublic())
                    throw new InvalidAccess("Method {$accessor} should be public",$subject,$propertyName,'public');

                $returnTypeFound = (string) $refMethod->getReturnType();

                if (preg_match('/get.+/',$accessor)) {
                    if ($returnTypeExpected != $returnTypeFound)
                        throw new AccessorReturnedWrongType("Get Accessor {$accessor} "
                            . "did not return expected type {$returnTypeExpected}, instead returned {$returnTypeFound}");
                } else {
                    if ($returnTypeFound != 'self')
                        throw new AccessorReturnedWrongType("Set Accessor {$accessor} should return fluent interface");
                }
            }
        } catch (\ReflectionException $e)
        {
            throw new \PhpSpec\Exception\Fracture\MethodNotFoundException("Accessor method {$accessor} not found",
                $subject, $accessor);
        }
    }

    public function negativeMatch($name, $subject, array $arguments)
    {
        // TODO: Implement negativeMatch() method.
    }
}