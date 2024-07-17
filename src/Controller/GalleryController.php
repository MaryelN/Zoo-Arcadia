<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Entity\Race;
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
    public function details(Habitat $habitat): Response
    {                
        return $this->render('gallery/habitat.html.twig', [
            'controller_name' => 'GalleryController',
            'title'=>'Habitat',
            'habitat'=>$habitat,
        ]);
    }
}
