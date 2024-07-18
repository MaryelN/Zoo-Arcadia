<?php

namespace App\DataFixtures;

use App\Entity\Habitat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HabitatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $habitat = new Habitat();
        $habitat->setName('Savane');
        $habitat->setDescription('La savane est un biome caractérisé par des herbes hautes et des arbres dispersés, qui abrite une grande variété d\'animaux sauvages. Les vastes étendues de la savane offrent un habitat idéal pour les grands herbivores comme les éléphants et les girafes, ainsi que pour les prédateurs tels que les lions et les léopards. Venez découvrir la beauté et la diversité de la savane au Zoo Arcadia.');
        $manager->persist($habitat);
        
        $habitat = new Habitat();
        $habitat->setName('Forêt');
        $habitat->setDescription('La forêt est un écosystème dense et luxuriant, caractérisé par une grande variété d\'arbres, de plantes et d\'animaux. Les forêts tropicales, tempérées et boréales abritent une diversité incroyable de créatures, des singes et des oiseaux exotiques aux cerfs et aux ours. Explorez les mystères de la forêt au Zoo Arcadia et découvrez ses habitants fascinants.');
        $manager->persist($habitat);
        
        $habitat = new Habitat();
        $habitat->setName('Jungle');
        $habitat->setDescription('La jungle est un biome dense et humide, caractérisé par une végétation luxuriante et une faune abondante. Les jungles tropicales sont le foyer de nombreuses espèces uniques, des singes et des serpents aux oiseaux et aux insectes. Plongez dans l\'aventure de la jungle au Zoo Arcadia et découvrez ses secrets cachés.');
        $manager->persist($habitat);
        
        $habitat = new Habitat();
        $habitat->setName('Prairies');
        $habitat->setDescription('Les prairies sont des écosystèmes ouverts et plats, caractérisés par des herbes hautes et des fleurs sauvages. Ces vastes étendues offrent un habitat idéal pour les herbivores comme les bisons et les antilopes, ainsi que pour les prédateurs tels que les loups et les coyotes. Explorez la beauté des prairies au Zoo Arcadia et découvrez la vie sauvage qui les habite.');
        $manager->persist($habitat);

        $manager->flush();
    }
}
