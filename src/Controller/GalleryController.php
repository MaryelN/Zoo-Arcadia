<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalReport;
use App\Entity\Habitat;
use App\Entity\Race;
use App\Repository\AnimalReportRepository;
use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    #[Route('/habitat/{id}', name:'habitat')]
    public function habitatDetails(
        habitat $habitat, 
        HabitatRepository $habitatRepository, 
        AnimalRepository $animalRepository, 
        int $id
        ): Response
    {            
        $habitat = $habitatRepository->find($id);
        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }

        $animals = $animalRepository->findByHabitat($habitat);

        return $this->render('gallery/habitat.html.twig', [
            'controller_name' => 'GalleryController',
            'title'=>'Habitat',
            'habitat'=>$habitat,
            'animals'=> $animals,
        ]);
    }

    #[Route('/race/{id}', name:'race')]
    public function raceDetails(
        race $race,
        RaceRepository $raceRepository,
        AnimalRepository $animalRepository,
        int $id
        ): Response
    {               
        $race = $raceRepository->find($id); 

        if (!$race) {
            throw $this->createNotFoundException('Race not found');
        }

        $animals = $animalRepository->findBy(['race' => $race]);

        return $this->render('gallery/race.html.twig', [
            'controller_name' => 'GalleryController',
            'title'=>'Race',
            'race'=>$race,
            'animals' => $animals,
        ]);
    }

    #[Route('/animal', name:'animal')]
    public function animal(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();

        return $this->render('gallery/animal.html.twig', [
            'controller_name' => 'GalleryController',
            'title'=>'Animaux',
            'animals'=>$animals
        ]);
    }

    #[Route('/animal/{id}', name:'animal_details')]
    public function animalDetails(
        Animal $animal,
        AnimalRepository $animalRepository,
        AnimalReportRepository $animalReportRepository,
        RaceRepository $raceRepository,
        int $id
        ): Response
    {
        $animal = $animalRepository->find($id);
        
        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }

        $latestReport = $animalReportRepository->findLatestAnimalReport($animal);

        $race = $raceRepository->find($animal->getRace());

        return $this->render('gallery/animal-details.html.twig', [
            'controller_name' => 'GalleryController',
            'title'=>'Animal',
            'animal'=>$animal,
            'latestReport'=>$latestReport,
            'race'=>$race
        ]);
    }

    #[Route('/animal/{id}/votes', name: 'animal_votes')]
    public function incrementVotes(Animal $animal, EntityManagerInterface $entityManager): RedirectResponse
    {
        $animal->setVotes($animal->getVotes() + 1);
        $entityManager->flush();

        return $this->redirectToRoute('app_gallery_animal_details', ['id' => $animal->getId()]);
    }
}
