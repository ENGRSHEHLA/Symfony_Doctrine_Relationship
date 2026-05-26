<?php

namespace App\DataFixtures;

use App\Entity\Starship;
use App\Entity\StarshipPart;
use App\Entity\StarshipStatusEnum;
use App\Factory\StarshipFactory;
use App\Factory\StarshipPartFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $starship = StarshipFactory::createOne()->_real();
        StarshipFactory::createOne([
            'name' => 'USS LeafyCruiser (NCC-0001)',
            'class' => 'Garden',
            'captain' => 'Jean-Luc Pickles',
            'status' => StarshipStatusEnum::IN_PROGRESS,
            'arrivedAt' => new \DateTimeImmutable('-1 day'),
        ]);

        $starship = new Starship();
        $starship->setName('USS Taco Tuesday');
        $starship->setClass('Tex-Mex');
        $starship->checkIn();
        $starship->setCaptain('James T. Nacho');
        $manager->persist($starship);

        $part = new StarshipPart();
        $part->setName('spoiler');
        $part->setNotes('There\'s no air drag in space, but it looks cool.');
        $part->setPrice(500);

        // $manager->persist($part);

        // $part1 = new StarshipPart();
        // $part1->setName('spoiler');
        // $part1->setNotes('There\'s no air drag in space, but it looks cool.');
        // $part1->setPrice(500);

        // $part2 = new StarshipPart();
        // $part2->setName('wing');
        // $part2->setNotes('Provides additional lift in atmosphere.');
        // $part2->setPrice(1000);

        // $manager->persist($part1);
        // $manager->persist($part2);
        // $starship->addPart($part1);
        // $starship->addPart($part2);
        // $manager->flush();

        $ship =  StarshipFactory::createOne([
            'name' => 'USS Espresso (NCC-1234-C)',
            'class' => 'Latte',
            'captain' => 'James T. Quick!',
            'status' => StarshipStatusEnum::COMPLETED,
            'arrivedAt' => new \DateTimeImmutable('-1 week'),
        ])->_real();

        $starshipPart = StarshipPartFactory::createOne([

            'starship' => $ship
        ])->_real();
        $ship->removePart($starshipPart);
        $manager->flush();
        dump($starshipPart);
        $ship =  StarshipFactory::createOne([
            'name' => 'USS Wanderlust (NCC-2024-W)',
            'class' => 'Delta Tourist',
            'captain' => 'Kathryn Journeyway',
            'status' => StarshipStatusEnum::WAITING,
            'arrivedAt' => new \DateTimeImmutable('-1 month'),
        ]);

        StarshipFactory::createMany(20);
        StarshipPartFactory::createMany(
            100
        );
    }
}
