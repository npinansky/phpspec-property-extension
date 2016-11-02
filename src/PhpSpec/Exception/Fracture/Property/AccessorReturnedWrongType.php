<?php

namespace PhpSpec\Exception\Fracture\Property;


use PhpSpec\Exception\Fracture\FractureException;

class AccessorReturnedWrongType extends FractureException
{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}