<?php

namespace PhpSpec\Matcher;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use PhpSpec\Exception\Exception;
use PhpSpec\Exception\Fracture\Missing;
use PhpSpec\Exception\Fracture\NoTypeDefined;
use PhpSpec\Exception\Fracture\Property\Annotation\Invalid;
use PhpSpec\Exception\Fracture\Property\Annotation\TooMany;
use PhpSpec\Exception\Fracture\Property\InvalidAccess;
use PhpSpec\Exception\Fracture\Property\MissingDocBlock;
use PhpSpec\Exception\Fracture\Property\WrongType;
use PhpSpec\Exception\Fracture\PropertyInvalidAccess;
use PhpSpec\Exception\Fracture\PropertyNotFoundException;
use PhpSpec\Matcher\Property\HaveAccessors;

/**
 * Class HasPropertyMatcher
 * Extension for PHPSpec to ensure that classes have expected properties.
 * @package PhpSpec\Matcher
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class HaveRelation implements MatcherInterface
{


    /**
     * This module handles "shouldHaveProperty()" calls
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     * @return bool
     */
    public function supports($name, $subject, array $arguments) : bool
    {
        return ($name == 'haveRelation') ? true:false;
    }

    /**
     * Not sure what this does...
     * @return int
     */
    public function getPriority()
    {
        return 100;
    }

    /**
     * Handles positive matches (we are looking for successful match)
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     */
    public function positiveMatch($name, $subject, array  $arguments)
    {
        list($prop, $access, $typeExpected) = $arguments;

        $typeExpected = 'ArrayCollection<' . $typeExpected . '>';

        $propertyTest = new HaveProperty();
        $propertyTest->positiveMatch($name, $subject, $arguments);

        $accessorTest = new HaveAccessors();
        $accessorTest->positiveMatch($name,$subject,[$prop, $typeExpected, ['add', 'remove', 'has', 'get']]);


    }

    /**
     * Not sure what this does??
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     * @return \ReflectionProperty
     * @throws InvalidAccess
     */
    public function negativeMatch($name, $subject, array $arguments)
    {
        return $this->positiveMatch($name,$subject, $arguments);
    }
}
