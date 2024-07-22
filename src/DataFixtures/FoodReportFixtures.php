<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\FoodReport;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FoodReportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $foodReport = new FoodReport();
            $foodReport->setDateTime($faker->dateTime());
            $foodReport->setFoodQuantity($faker->paragraph());
            $foodReport->setDetails($faker->paragraph());

            $animal = $this->getReference('animal_' . rand(0, 9));
            $foodReport->setAnimalId($animal);

            $user = $this->getReference('user_' . rand(0, 4));
            $foodReport->setUserId($user);

            $manager->persist($foodReport);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            AnimalFixtures::class,
            UserFixtures::class,
        ];
    } 
}
