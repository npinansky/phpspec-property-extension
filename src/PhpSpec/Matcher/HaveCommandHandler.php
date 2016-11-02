<?php

namespace PhpSpec\Matcher;


use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use PhpSpec\Exception\Exception;
use PhpSpec\Exception\Fracture\MethodNotFoundException;
use PhpSpec\Exception\Fracture\Missing;
use PhpSpec\Exception\Fracture\NoTypeDefined;
use PhpSpec\Exception\Fracture\Property\Annotation\Invalid;
use PhpSpec\Exception\Fracture\Property\Annotation\TooMany;
use PhpSpec\Exception\Fracture\Property\InvalidAccess;
use PhpSpec\Exception\Fracture\Property\MissingDocBlock;
use PhpSpec\Exception\Fracture\Property\WrongType;
use PhpSpec\Exception\Fracture;

/**
 * Class HaveCommandHandler
 * Custom PHPSpec Matcher to make sure command handler classes have a handler() method.
 * @package PhpSpec\Matcher
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class HaveCommandHandler implements MatcherInterface
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
        return ($name == 'haveCommandHandler') ? true:false;
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
        // Use handler() unless method name otherwise specified
        $methodName = $arguments[1] ?? 'handle';
        $handlesCommand = $arguments[0];

        // Look around for the method in the class
        $refClass = new \ReflectionClass($subject);
        try {
            $refMethod = $refClass->getMethod($methodName);
        } catch (\ReflectionException $e) {
            // Method not found? throw exception
            throw new MethodNotFoundException(null, $subject, $methodName);
        }

        // Make sure the method accepts the command we're trying to send
        $refParam = $refMethod->getParameters();
        if (sizeof($refParam) === 0)
            throw new \PhpSpec\Exception\Fracture\HandlerDoesNotAcceptExpectedCommand($refClass, $methodName,
                get_class($handlesCommand), 'none', 'Expected ' . get_class($handlesCommand) . ' but no typehint found for handler function');

        $refParam = $refParam[0];
        $cmdType = $refParam->getType();

        $className = (string) $cmdType;

        if ( ! $handlesCommand instanceof $className)
            throw new \PhpSpec\Exception\Fracture\HandlerDoesNotAcceptExpectedCommand($refClass,
                $methodName,
                get_class($handlesCommand), $cmdType);

        // Method must be public
        if (!$refMethod->isPublic())
            throw new \PhpSpec\Exception\Fracture\HandlerMethodNotPublic($subject);

        // everything ok!
        return true;
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
