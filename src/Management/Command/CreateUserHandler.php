<?php

namespace Management\Command;

use App\MessageHandler\CommandHandlerInterface;
use Management\Domain\User;
use Management\Domain\UserRepository;
use Management\Domain\ValueObject\UserPassword;
use Management\Domain\ValueObject\UserUsername;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class CreateUserHandler implements MessageHandlerInterface, CommandHandlerInterface
{
    public function __construct(private UserRepository $repository, private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @param CreateUser $command
     * @return User
     */
    public function __invoke(CreateUser $command): User
    {
        $user = User::create(
            new UserUsername($command->getUsername())
        );
        $user->setPassword(new UserPassword($this->passwordHasher->hashPassword($user, $command->getPassword())));

        $this->repository->save($user);

        return $user;
    }
}
