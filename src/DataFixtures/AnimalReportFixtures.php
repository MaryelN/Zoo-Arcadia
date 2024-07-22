<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\AnimalReport;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnimalReportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $veterinaryUser = $this->getReference('user_veterinary');

        for ($i = 0; $i < 10; $i++) {
            $animalReport = new AnimalReport();
            $animalReport->setDetails($faker->paragraph());
            $animalReport->setTimeStamp(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            $animalReport->setProposedFood($faker->paragraph());
            $animalReport->setProposedQuantity($faker->numberBetween(1, 10).' kg pour les adultes et '. $faker->numberBetween(1, 5).' kg pour les petits');
            $animalReport->setHealth($faker->word());

            $animal = $this->getReference('animal_' . rand(0, 5));
            $animalReport->setAnimalId($animal);

            $animalReport->setUserId($veterinaryUser);

            $manager->persist($animalReport);
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
