<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
        $comment = new Comment();
        $comment->setName($faker->name());
        $comment->setLastname($faker->lastName());
        $comment->setEmail($faker->email());
        $comment->setComment($faker->text());
        $comment->setRating($faker->numberBetween(3, 5));
        $comment->setValidation($faker->boolean());
        $comment->setTimestamp(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 years', 'now')));

        $manager->persist($comment);
        }
        $manager->flush();
    }
}
