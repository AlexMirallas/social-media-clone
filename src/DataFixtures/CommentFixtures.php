<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Thread;
use App\Entity\Comment;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\ThreadFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i=0; $i<1000; $i++) {
            $comment = new Comment();
            $comment->setCommentBody($faker->paragraph())
                    ->setUser($this->getReference('user_' . rand(0, 49), User::class))
                    ->setThread($this->getReference('thread_' . rand(0, 99), Thread::class))
                    ->setDtCreation($faker->dateTimeBetween('-1 year', 'now'));
            $manager->persist($comment);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ThreadFixtures::class,
        ];
    }
}
