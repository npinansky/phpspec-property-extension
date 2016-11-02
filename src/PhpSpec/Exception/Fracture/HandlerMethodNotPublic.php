<?php
namespace PhpSpec\Exception\Fracture;
use PhpSpec\Exception\Exception;
use PhpSpec\Exception\Fracture\PropertyNotFoundException;

/**
 * Class HandlerMethodNotPublic
 * Exception thrown when a handler method exists but is declared as non-public
 * @package spec\Springfield\CoreBundle\Command
 * @author Nick Pinansky <nicholas.pinansky@wbdcorp.com>
 */
class HandlerMethodNotPublic extends FractureException
{
    private $className;
    private $handlerMethodName;
    private $subject;

    public function __construct(\ReflectionMethod $subject, $message = NULL)
    {
        $this->subject = $subject;
        $this->handlerMethodName = $subject->getName();
        $this->className = $subject->getDeclaringClass()->getName();

        $message = $message ?? "The command handler method named {$this->handlerMethodName} exists but is not "
            . "publicly accessible";

        parent::__construct($message);
    }

    /**
     * Get accessor for the command handler class name
     * @return string
     */
    public function getClassName() : string
    {
        return $this->className;
    }

    /**
     * Get accessor for handler method name
     * @return string
     */
    public function getHandlerMethodName() : string
    {
        return $this->handlerMethodName;
    }
}
