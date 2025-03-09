<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{   
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {   
    
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setUsername($faker->userName());
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, $faker->password()));
            $user->setRoles(['ROLE_USER']);
            $user->setDtCreation($faker->dateTimeBetween('-1 year', 'now'));

            $manager->persist($user);
            $this->addReference("user_$i", $user);
        }

        $manager->flush();
    }
}
