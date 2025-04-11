<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\Picture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PictureFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        foreach($users as $user)
        {        
            $nbPictures = $faker->numberBetween(5, 10);

            for($i = 0; $i < $nbPictures; $i++) {
                $picture = new Picture();
                $picture->setDescription($faker->sentence(4, true))
                    ->setDate($faker->dateTimeBetween('-1 year'))
                    ->setFilename($faker->word() . ".jpg")
                    ->setCreatedBy($user);
        
                $manager->persist($picture);
            }
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
                    ->setEvent($event)
                    ->setCreatedBy($event->getCreatedBy());
        
                $manager->persist($picture);
            }
        
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixture::class,
            UserFixture::class
        ];
    }
}
