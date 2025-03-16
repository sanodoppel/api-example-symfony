<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const DEFAULT_USERNAME = 'test';
    public const DEFAULT_PASSWORD = 'test';

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername(self::DEFAULT_USERNAME);
        $user->setPassword(password_hash(self::DEFAULT_PASSWORD, PASSWORD_BCRYPT));

        $manager->persist($user);

        $manager->flush();
    }
}
