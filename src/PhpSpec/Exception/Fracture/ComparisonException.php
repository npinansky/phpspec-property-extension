<?php

namespace PhpSpec\Exception\Fracture;

/**
 * Interface ComparisonException
 * Exception thrown when a value found doesn't match what is expected
 * @package PhpSpec\Exception\Fracture
 */
interface ComparisonException
{
    public function getExpected();
    public function getFound();
}