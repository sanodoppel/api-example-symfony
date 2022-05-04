<?php

namespace Shared\Domain\Exception;

use Exception;

class DuplicatedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Duplicated entity', 0, null);
    }
}
