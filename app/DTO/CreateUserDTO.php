<?php

namespace App\DTO;

use Shared\Domain\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO extends AbstractDTO
{
    #[Assert\NotBlank]
    readonly protected ?string $username;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    readonly protected ?string $password;

    /**
     * @param string|null $username
     * @param string|null $password
     */
    public function __construct(?string $username, ?string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}
