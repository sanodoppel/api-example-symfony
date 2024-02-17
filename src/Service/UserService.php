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
     * @param FormInterface $form
     * @return User
     */
    public function create(FormInterface $form): User
    {
        /**
         * @var User $user
         */
        $user = $form->getData();

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $form->get('password')->getData()
        ));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
