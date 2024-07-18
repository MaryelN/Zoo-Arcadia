<?php

namespace App\DataFixtures;

use App\Entity\Habitat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class HabitatFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    
    public function load(ObjectManager $manager): void
    {


        $habitatData = [
            ['name' => 'Savane', 'description' => 'La savane est un biome caractérisé par des herbes hautes et des arbres dispersés, qui abrite une grande variété d\'animaux sauvages. Les vastes étendues de la savane offrent un habitat idéal pour les grands herbivores comme les éléphants et les girafes, ainsi que pour les prédateurs tels que les lions et les léopards. Venez découvrir la beauté et la diversité de la savane au Zoo Arcadia.'],
            ['name' => 'Forêt', 'description' => 'La forêt est un écosystème dense et luxuriant, caractérisé par une grande variété d\'arbres, de plantes et d\'animaux. Les forêts tropicales, tempérées et boréales abritent une diversité incroyable de créatures, des singes et des oiseaux exotiques aux cerfs et aux ours. Explorez les mystères de la forêt au Zoo Arcadia et découvrez ses habitants fascinants.'],
            ['name' => 'Jungle', 'description' => 'La jungle est un biome dense et humide, caractérisé par une végétation luxuriante et une faune abondante. Les jungles tropicales sont le foyer de nombreuses espèces uniques, des singes et des serpents aux oiseaux et aux insectes. Plongez dans l\'aventure de la jungle au Zoo Arcadia et découvrez ses secrets cachés.'],
            ['name' => 'Prairies', 'description' => 'Les prairies sont des écosystèmes ouverts et plats, caractérisés par des herbes hautes et des fleurs sauvages. Ces vastes étendues offrent un habitat idéal pour les herbivores comme les bisons et les antilopes, ainsi que pour les prédateurs tels que les loups et les coyotes. Explorez la beauté des prairies au Zoo Arcadia et découvrez la vie sauvage qui les habite.'],
        ];

        foreach ($habitatData as $data) {
            $habitat = new Habitat();
            $habitat->setName($data['name']);
            $habitat->setDescription($data['description']);
            
            $imageName = $data['name'] . '.jpg';
            $habitat->setImageName($imageName);


            // Handle the image file
            $imagePath = __DIR__ . '/../../public/uploads/habitat_images/' . $imageName;
            if (file_exists($imagePath)) {
                $fileSize = filesize($imagePath);
                echo "File size of $imagePath: $fileSize bytes\n";
                $uploadedFile = new UploadedFile(
                    $imagePath,
                    $imageName,
                    'image/jpeg',
                    null,
                    true // Mark it as test file
                );
        
                $habitat->setImageFile($uploadedFile);
                $habitat->setImageSize($fileSize);
            }

            $manager->persist($habitat);
        }

        $manager->flush();
    }
}
