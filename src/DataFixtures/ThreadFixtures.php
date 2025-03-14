<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Thread;
use App\Entity\Subreddit;
use App\DataFixtures\SubredditFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ThreadFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $thread = new Thread();
            $thread->setTitle($faker->sentence());
            $thread->setBody($faker->paragraph());
            $thread->setDtCreation($faker->dateTimeBetween('-1 year', 'now'));
            $thread->setSubreddit($this->getReference("subreddit_" . rand(0, 9), Subreddit::class));
            $thread->setOriginalPoster($this->getReference("user_" . rand(0, 49), User::class));
            $thread->setUpvotes(rand(0, 2000));
            $thread->setDownvotes(rand(0, 2000));
            $manager->persist($thread);
            $this->addReference("thread_$i", $thread);
        }
        

        $manager->flush();
    }

    public function getDependencies():array
    {
        return [
            SubredditFixtures::class,
        ];
    }
}
