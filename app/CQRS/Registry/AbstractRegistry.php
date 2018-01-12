<?php

namespace App\CQRS\Registry;

abstract class AbstractRegistry
{
    /**
    * Check if the given argument is traversable
    * @param $argument
    * @return bool
    */
    protected function isTraversable($argument)
    {
        return is_array($argument) || $argument instanceof \Traversable;
    }
}
