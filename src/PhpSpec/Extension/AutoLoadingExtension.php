<?php

namespace PhpSpec\Extension;


use PhpSpec\Extension;
use PhpSpec\Matcher\HasPropertyMatcher;
use PhpSpec\Matcher\Property\BeType;
use PhpSpec\ServiceContainer;

/**
 * Register new matchers and generators 
 * Class EntityExtension
 * @package PhpSpec\Extension
 * @author Nick Pinansky <pinansky@gmail.com>
 */
abstract class AutoLoadingExtension implements ExtensionInterface
{

    /**
     * Any intialization routines for the extension go here
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $this->addMatchers($container);
    }

    abstract protected function getMatchers() : array;

    /**
     * Register the "matchers" (tests) with the dependency container
     * @param ServiceContainer $container
     */
    protected function addMatchers(ServiceContainer $container)
    {
        foreach ($this->getMatchers() as $matcherName => $class)
          {
            $matcherName = 'matchers.' . $matcherName;
            $container->set($matcherName, function(ServiceContainer $container) use ($class) {
                return new $class();
            });
        }
    }
}
