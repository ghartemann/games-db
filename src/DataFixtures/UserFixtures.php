<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const USERS = [
        [
            'email' => 'vin.diesel@wanadoo.fr',
            'roles' => '',
            'password' => 'family',
        ], [
            'title' => 'RollerCoaster Tycoon',
            'category' => 'Builder',
            'description' => "Construisez un parc d'attractions",
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userName) {
            $game = new Game();
            $game
                ->setTitle($gameName['title'])
                ->setCategory($this->getReference('category_' . $gameName['category']))
                ->setDescription($gameName['description']);
            $manager->persist($game);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
