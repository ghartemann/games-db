<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    const GAMES = [
        [
            'title' => 'Myst',
            'category' => 'Point & Click',
            'description' => 'Cliquez pour avancer',
        ], [
            'title' => 'RollerCoaster Tycoon',
            'category' => 'Builder',
            'description' => "Construisez un parc d'attractions",
        ], [
            'title' => 'Riven',
            'category' => 'Point & Click',
            'description' => "Cliquez pour avancer 2: the Reckoning",
        ], [
            'title' => 'Half-Life',
            'category' => 'FPS',
            'description' => "Boum boum pan pan",
        ], [
            'title' => 'Half-Life',
            'category' => 'FPS',
            'description' => 'Boum boum pan pan',
        ],
    ];

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::GAMES as $gameName) {
            $game = new Game();

            $slug = $this->slugify->generate($gameName['title']);

            $game
                ->setTitle($gameName['title'])
                ->setCategory($this->getReference('category_' . $gameName['category']))
                ->setDescription($gameName['description'])
                ->setSlug($slug);
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
