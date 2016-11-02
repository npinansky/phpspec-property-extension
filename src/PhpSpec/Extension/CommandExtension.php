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
class CommandExtension extends AutoLoadingExtension
{
    /**
     * Register the "matchers" (tests) with the dependency container
     * @param ServiceContainer $container
     */
    protected function getMatchers() : array
    {
        return ['hadnler_method_exists' => 'PhpSpec\Matcher\HaveCommandHandler'];
    }
}
