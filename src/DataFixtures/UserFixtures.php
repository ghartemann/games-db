<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const USERS = [
        [
            'email' => 'vin.diesel@wanadoo.fr',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'family',
        ], [
            'email' => 'test@test.com',
            'roles' => ['ROLE_USER'],
            'password' => "test",
        ],
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userName) {
            $user = new User();

            $hashedPassword = $this
                ->passwordHasher
                ->hashPassword(
                    $user,
                    $userName['password']
                );

            $user
                ->setEmail($userName['email'])
                ->setPassword($hashedPassword)
                ->setRoles($userName['roles']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
