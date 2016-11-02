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
 */
class EntityExtension implements ExtensionInterface
{

    /**
     * Any intialization routines for the extension go here
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $this->addMatchers($container);
    }

    /**
     * Register the "matchers" (tests) with the dependency container
     * @param ServiceContainer $container
     */
    protected function addMatchers(ServiceContainer $container)
    {
        $matchers = [
            'property_exists'                         => 'PhpSpec\Matcher\HaveProperty',
#            'property_annotation_doctrine_beIdField'  => 'PhpSpec\Matcher\Property\Annotations\Doctrine\BeIdField',
#            'property_annotation_doctrine_HasCustomGenerator' =>
#                'PhpSpec\Matcher\Property\Annotations\Doctrine\HasCustomGenerator',
        ];


        foreach ($matchers as $matcherName => $class)
          {
            $matcherName = 'matchers.' . $matcherName;
            $container->set($matcherName, function(ServiceContainer $container) use ($class) {
                return new $class();
            });
        }
    }
}