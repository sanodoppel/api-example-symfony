<?php

namespace Management\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use Management\Domain\User;
use Management\Domain\UserRepository;
use Shared\Domain\Exception\DuplicatedException;
use Shared\Infrastructure\Persistence\DoctrineRepository;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }

    public function save(User $user): void
    {

        if ($this->findOneBy(['username' => $user->getUsername()])) {
            throw new DuplicatedException();
        }

        $this->persist($user);
    }
}
