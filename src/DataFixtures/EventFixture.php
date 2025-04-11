<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Event;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EventFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        foreach($users as $user)
        {   
        
            // Je génère entre 5 et 10 évènements
            $nbEvents = $faker->numberBetween(5, 10);

            for($i = $nbEvents; $i >= 0; $i--) {

                $event = new Event();
                $event->setTitle($faker->sentence(4, true))
                    ->setDate($faker->dateTimeBetween('-1 year'))
                    ->setCreatedBy($user);
        
                $manager->persist($event);
            }
        }

        $manager->flush();
    }
}
