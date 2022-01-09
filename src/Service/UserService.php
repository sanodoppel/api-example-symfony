<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     * @param string $username
     * @param string $password
     * @return User
     */
    public function register(string $username, string $password): User
    {
        $user = new User();

        $user->setUsername($username);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $password
        ));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function list(int $limit = User::LIMIT, int $offset = 0): array
    {
        return $this->entityManager->getRepository(User::class)->findBy(
            [],
            ['id' => 'DESC'],
            $limit,
            $offset
        );
    }
}
