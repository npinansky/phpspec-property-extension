<?php
namespace PhpSpec\Exception\Fracture;
use PhpSpec\Exception\Exception;
use PhpSpec\Exception\Fracture\PropertyNotFoundException;

/**
 * Class HandlerDoesNotAcceptExpectedCommand
 * Exception thrown if handler class does not accept the command type is ostensibly handles
 * @package spec\Springfield\CoreBundle\Command
 * @author Nick Pinansky <nichols.pinansky@wbdcorp.com>
 */
class HandlerDoesNotAcceptExpectedCommand extends FractureException
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string $methodName
     */
    private $methodName;

    /**
     * @var string $commandType
     */
    private $commandType;


    /**
     * HandlerDoesNotAcceptExpectedCommand constructor.
     * @param \ReflectionMethod $subject
     * @param string $handlerFunctionName
     * @param string $commandType
     */
    public function __construct(\ReflectionClass $subject,string $handlerFunctionName, string $commandType, 
                                string $foundType = 'none', string $message = null)
    {
        $this->className = $subject->getName();
        $this->methodName = $handlerFunctionName;
        $this->commandType = $commandType;

        $message = $message ?? "Command handler {$this->className}::{$handlerFunctionName} does not handle "
            . "command type {$commandType} only {$foundType}";

        parent::__construct($message);
    }

    /**
     * Get accessor for command type
     * @return string
     */
    public function getCommandType() : string
    {
        return $this->commandType;
    }

    /**
     * Get accessor for method name
     * @return string
     */
    public function getMethodName() : string
    {
        return $this->methodName;
    }

    /**
     * Get accessor for class name
     * @return string
     */
    public function getClassName() : string
    {
        return $this->className;
    }
}

