<?php

namespace App\Controller;

use App\Document\comment;
use App\Form\CommentsType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comments', name: 'app_comments', methods: ['GET', 'POST'])]
    public function sendComment(Request $request, DocumentManager $dm): Response
    {
        $comment = new comment();

        $form = $this->createForm(CommentsType::class, $comment);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $comment = $form->getData();

            $dm->persist($comment);
            $dm->flush();

            $this->addFlash('success', 'Merci pour votre commentaire');
            return $this->redirectToRoute('app_index');
        }
        
        return $this->render('pages/comments.html.twig', [
            'form' => $form->createView(),
            'title' => 'Commentaires',
        ]);
    }
}
