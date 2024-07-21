<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Habitat;
use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $animalData = [
            // Default animals
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_savane', 'race' => 'race_mammifères'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_forêt', 'race' => 'race_mammifères'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_jungle', 'race' => 'race_reptiles'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_savane', 'race' => 'race_insectes'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_prairies', 'race' => 'race_oiseaux'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_jungle', 'race' => 'race_mammifères'],
            //Extra animals
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_forêt', 'race' => 'race_mammifères'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_forêt', 'race' => 'race_mammifères'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_jungle', 'race' => 'race_reptiles'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_savane', 'race' => 'race_insectes'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_prairies', 'race' => 'race_oiseaux'],
            ['name' => $faker->name(), 'details' => $faker->paragraph(), 'votes' => $faker->numberBetween(0, 100), 'habitat' => 'habitat_jungle', 'race' => 'race_mammifères'],
        ];

        foreach ($animalData as $index => $data) {
            $animal = new Animal();
            $animal->setName($data['name']);
            $animal->setdetails($data['details']);
            $animal->setVotes($data['votes']);
        
            $habitat = $this->getReference($data['habitat']);
            $animal->setHabitat($habitat);

            $race = $this->getReference($data['race']);
            $animal->setRace($race);
        
            $manager->persist($animal);
            $this->addReference('animal_' . $index, $animal);
        }

        $manager->flush();
    }

    
    public function getDependencies()
    {
        return [
            HabitatFixtures::class,
            RaceFixtures::class,
        ];
    }    
}

