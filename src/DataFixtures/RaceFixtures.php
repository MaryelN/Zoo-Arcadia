<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $races = [
            ['name' => 'Mammifères', 'description' => 'Les mammifères sont des animaux à sang chaud, généralement couverts de poils, et nourrissant leurs petits avec du lait. Au Zoo Arcadia, vous trouverez une variété impressionnante de mammifères, des imposants éléphants aux agiles singes, en passant par les majestueux lions. Leur comportement complexe et leur diversité fascinent toujours les visiteurs.'],
            ['name' => 'Reptiles', 'description' => 'Les reptiles et amphibiens sont des créatures fascinantes à sang froid, incluant les serpents, les lézards, les tortues et les grenouilles. Ces animaux se distinguent par leurs écailles ou leur peau lisse et humide, ainsi que par leurs capacités uniques d\'adaptation et de survie. Venez découvrir la diversité incroyable de ces espèces au Zoo Arcadia.'],
            ['name' => 'Oiseaux', 'description' => 'Les oiseaux, avec leurs plumes colorées et leurs chants mélodieux, sont parmi les animaux les plus captivants. Le Zoo Arcadia abrite une vaste gamme d\'oiseaux, des perroquets exotiques aux rapaces majestueux. Observez leur comportement social, leurs techniques de vol et leurs rituels de parade nuptiale dans notre volière.'],
            ['name' => 'Insectes', 'description' => 'Les insectes et arachnides sont des créatures fascinantes qui jouent des rôles cruciaux dans nos écosystèmes. Au Zoo Arcadia, découvrez une diversité étonnante d\'insectes, des papillons colorés aux fourmis industrielles, ainsi que des arachnides comme les araignées et les scorpions. Leur anatomie unique, leurs comportements complexes et leurs interactions écologiques captivent les visiteurs de tous âges.'],
        ];

        foreach ($races as $index => $data) {
            $race = new Race();
            $race->setLabel($data['name']);
            $race->setDescription($data['description']);
            
            $manager->persist($race);
            $this->addReference('race_' . strtolower($data['name']), $race);         $this->addReference('race_' . $index, $race);
        }
        $manager->flush();
    }
}