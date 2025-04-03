<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Event;
use App\Entity\Picture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PictureFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        $nbPictures = $faker->numberBetween(5, 10);

        for($i = 0; $i < $nbPictures; $i++) {
            $picture = new Picture();
            $picture->setDescription($faker->sentence(4, true))
                ->setDate($faker->dateTimeBetween('-1 year'))
                ->setFilename($faker->word() . ".jpg");
    
            $manager->persist($picture);
        }

        $eventRepository = $manager->getRepository(Event::class);
        $events = $eventRepository->findAll();

        foreach($events as $event)
        {
            $nbPictures = $faker->numberBetween(2, 10);

            for($i = 0; $i < $nbPictures; $i++) {
                $picture = new Picture();
                
                $picture->setDescription($faker->sentence(4, true))
                    ->setDate($faker->dateTimeBetween('-1 year'))
                    ->setFilename($faker->word() . ".jpg")
                    ->setEvent($event);
        
                $manager->persist($picture);
            }
        }

        $manager->flush();
    }
}
