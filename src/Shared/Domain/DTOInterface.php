<?php

namespace Shared\Domain;

interface DTOInterface
{
    public function get(string $param): mixed;
}
