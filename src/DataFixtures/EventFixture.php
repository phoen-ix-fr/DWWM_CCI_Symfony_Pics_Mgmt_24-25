<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Event;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventFixture extends Fixture implements DependentFixtureInterface
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

    public function getDependencies(): array
    {
        return [
            UserFixture::class
        ];
    }
}
