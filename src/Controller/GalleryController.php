<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Entity\Race;
use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gallery', name: 'app_gallery_')]
class GalleryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        HabitatRepository $habitatRepository, 
        RaceRepository $raceRepository, 
        Request $request
    ): Response
    {
        $races = $raceRepository->findAll();
        $habitats = $habitatRepository->findAll();


        return $this->render('gallery/index.html.twig', [
            'controller_name' => 'GalleryController',
            'title' => 'Le Zoo et les animaux',
            'races' => $races,
            'habitats' => $habitats
        ]);
    }

    #[Route('/{id}', name:'habitat')]
    public function details(habitat $habitat, 
                            HabitatRepository $habitatRepository, 
                            AnimalRepository $animalRepository, 
                            int $id): Response
    {            
        $habitat = $habitatRepository->find($id);
        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }

        // Get animals for the habitat
        $animals = $animalRepository->findByHabitat($habitat);

        return $this->render('gallery/habitat.html.twig', [
            'controller_name' => 'GalleryController',
            'title'=>'Habitat',
            'habitat'=>$habitat,
            'animals'=> $animals,
        ]);
    }
    #[Route('/{id}', name:'race')]
    public function groups(race $race): Response
    {                
        return $this->render('gallery/race.html.twig', [
            'controller_name' => 'GalleryController',
            'title'=>'Habitat',
            'race'=>$race,
        ]);
    }
}
