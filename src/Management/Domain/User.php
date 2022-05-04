<?php

namespace Management\Domain;

use Management\Domain\ValueObject\UserPassword;
use Management\Domain\ValueObject\UserUsername;
use Shared\Domain\AggregateRoot;
use Shared\Domain\ValueObject\DateTime;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class User extends AggregateRoot implements PasswordAuthenticatedUserInterface
{
    private DateTime $createdAt;
    private UserPassword $password;

    /**
     * @param UserUsername $username
     */
    public function __construct(
        private UserUsername $username,
    ) {
        parent::__construct();
        $this->createdAt = new DateTime();
    }

    /**
     * @param UserUsername $username
     * @return static
     */
    public static function create(
        UserUsername $username,
    ): self {
        return new self($username);
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username->value();
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password->value();
    }

    /**
     * @param UserPassword $password
     */
    public function setPassword(UserPassword $password): void
    {
        $this->password = $password;
    }
}
