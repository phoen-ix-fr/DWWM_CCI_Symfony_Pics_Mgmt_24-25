<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {

    }
    
    public function load(ObjectManager $manager): void
    {
        $nbUsers = 5;

        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail("jdoe@app.net")
            ->setFirstname("John")
            ->setLastname("Doe");
        
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "azerty123!&"));

        $manager->persist($user);

        for($i = 0; $i < $nbUsers; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName());
            
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $faker->password()));
    
            $manager->persist($user);
        }

        $manager->flush();
    }
}
