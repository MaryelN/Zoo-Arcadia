<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(CommentRepository $CommentRepository): Response
    {
        $comments = $CommentRepository->findLatestComment();

        return $this->render('pages/index.html.twig',[
            'comments' => $comments,
            'controller_name' => 'IndexController'
            ]);
    }
}
