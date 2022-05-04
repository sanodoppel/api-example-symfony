<?php

namespace Shared\Domain;

abstract class AbstractDTO implements DTOInterface
{
    public function get(string $param): mixed
    {
        return $this->$param;
    }
}
