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
class HaveProperty implements MatcherInterface
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
        return ($name == 'haveProperty') ? true:false;
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

        $refClass = new \ReflectionClass($subject);

        try {
            // Get the property reflector, will throw exception if not exists
            $refProp = $refClass->getProperty($prop);

            // if we have an access type, check if it matches what we got
            if ($access) {
                // make sure the access level specified is valid
                if (!preg_match('/public|protected|private/', strtolower($access)))
                    throw new InvalidAccess("Access type specified {$access} not valid, must be public, "
                        . "private, or protected", $subject, $prop, $access);

                // make sure the access type what we expecting
                $accessMethod = 'is' . ucfirst(strtolower($access));
                if (!$refProp->$accessMethod())
                    throw new InvalidAccess(NULL, $subject, $prop, $access);
            }

            // if we got a datatype, check it is hinted in the doc
            if ($typeExpected) {
                $docComment = $refProp->getDocComment();
                
                if ($docComment === false)
                    throw new MissingDocBlock($refProp);

                $docBlock  = \phpDocumentor\Reflection\DocBlockFactory::createInstance()->create($docComment);


                $tags =  $docBlock->getTagsByName('var');

                if (count($tags) === 0)
                    throw new \PhpSpec\Exception\Fracture\Property\Annotation\Missing($refProp, 'var');
                
                if (count($tags) > 1 )
                    throw new TooMany($refProp, 'var', 1, count($tags));

                $typeFound = array_shift($tags)->getType();

                if (empty($typeFound) || ! isset($typeFound) || preg_match('/^\s?$/', $typeFound))
                    throw new NoTypeDefined($refProp,$typeExpected);

                $typeExpected = preg_replace('/^\\\/', '', $typeExpected);
                $typeFound = preg_replace('/^\\\/', '', $typeFound);


                if ($typeFound != $typeExpected)
                    throw new WrongType($refProp,$typeExpected, $typeFound);

            }

            $accessorTest = new HaveAccessors();
            $accessorTest->positiveMatch($name,$subject,[$prop, $typeExpected]);

        } catch (\ReflectionException $e) {
            throw new PropertyNotFoundException("Property named {$prop} was expected, but not found", $subject, $prop);
        }
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
