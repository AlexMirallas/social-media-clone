<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Subreddit;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SubredditFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i=0; $i<10; $i++) {
            $subreddit = new Subreddit();
            $subreddit->setTitle($faker->word());
            $subreddit->setDescription($faker->sentence(1, true));
            $subreddit->setDtCreation($faker->dateTimeThisYear());
            $subreddit->setUser($this->getReference('user_' . rand(0, 49), User::class));
            $manager->persist($subreddit);

            $this->addReference("subreddit_$i", $subreddit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
