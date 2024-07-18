<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RaceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

            $race = new Race();
            $race->setLabel('Mammifères');
            $race->setDescription('Les mammifères sont des animaux à sang chaud, généralement couverts de poils, et nourrissant leurs petits avec du lait. Au Zoo Arcadia, vous trouverez une variété impressionnante de mammifères, des imposants éléphants aux agiles singes, en passant par les majestueux lions. Leur comportement complexe et leur diversité fascinent toujours les visiteurs.');
            $manager->persist($race);
            
            $race = new Race();
            $race->setLabel('Reptiles et Amphibiens');
            $race->setDescription('Les reptiles et amphibiens sont des créatures fascinantes à sang froid, incluant les serpents, les lézards, les tortues et les grenouilles. Ces animaux se distinguent par leurs écailles ou leur peau lisse et humide, ainsi que par leurs capacités uniques d\'adaptation et de survie. Venez découvrir la diversité incroyable de ces espèces au Zoo Arcadia.');
            $manager->persist($race);
            
            $race = new Race();
            $race->setLabel('Oiseaux');
            $race->setDescription('Les oiseaux, avec leurs plumes colorées et leurs chants mélodieux, sont parmi les animaux les plus captivants. Le Zoo Arcadia abrite une vaste gamme d\'oiseaux, des perroquets exotiques aux rapaces majestueux. Observez leur comportement social, leurs techniques de vol et leurs rituels de parade nuptiale dans notre volière.');
            $manager->persist($race);
            
            $race = new Race();
            $race->setLabel('Insectes et Arachnides');
            $race->setDescription('Les insectes et arachnides sont des créatures fascinantes qui jouent des rôles cruciaux dans nos écosystèmes. Au Zoo Arcadia, découvrez une diversité étonnante d\'insectes, des papillons colorés aux fourmis industrielles, ainsi que des arachnides comme les araignées et les scorpions. Leur anatomie unique, leurs comportements complexes et leurs interactions écologiques captivent les visiteurs de tous âges.');
            $manager->persist($race);

          $manager->flush();
  }
}