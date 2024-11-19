<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(
        HabitatRepository $habitatRepository, 
        CommentRepository $commentRepository
    ): Response
    {

        $comments = $commentRepository->findLatestComment(3);
        $habitats = $habitatRepository->findAll();

        return $this->render('pages/index.html.twig', [
            'comments' => $comments,
            'habitats' => $habitats,
            'controller_name' => 'IndexController',
        ]);
    }
}
