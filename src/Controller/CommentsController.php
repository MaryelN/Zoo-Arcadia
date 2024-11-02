<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentsController extends AbstractController
{
    #[Route('/comments', name: 'app_comments')]
    public function sendComment(Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $comment = $form->getData();

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Merci pour votre commentaire');
            return $this->redirectToRoute('app_index');
        }
        
        return $this->render('pages/comments.html.twig', [
            'form' => $form->createView(),
            'title' => 'Commentaires',
        ]);
    }
}
