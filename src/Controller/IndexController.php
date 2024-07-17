<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(
        CommentRepository $CommentRepository, 
        HabitatRepository $habitatRepository, 
        ): Response
    {
        $comments = $CommentRepository->findLatestComment();
        $habitats = $habitatRepository->findAll();

        return $this->render('pages/index.html.twig',[
            'comments' => $comments,
            'habitats' => $habitats,
            'controller_name' => 'IndexController'
            ]);
    }
}
