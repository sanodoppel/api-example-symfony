<?php

namespace Management\Command;

use Shared\Domain\DTOInterface;

class CreateUser
{

    readonly private string $username;
    readonly private string $password;

    public function __construct(DTOInterface $dto)
    {
        $this->username = $dto->get('username');
        $this->password = $dto->get('password');
    }

    /**
     * @return mixed|string
     */
    public function getUsername(): mixed
    {
        return $this->username;
    }

    /**
     * @return mixed|string
     */
    public function getPassword(): mixed
    {
        return $this->password;
    }
}
