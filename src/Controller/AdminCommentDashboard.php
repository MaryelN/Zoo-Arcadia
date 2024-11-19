<?php

namespace App\Controller;

use App\Document\comment;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentDashboard extends AbstractController
{
    #[Route('/admin/comments', name: 'admin_comments')]
    public function index(DocumentManager $dm): Response
    {
        $comments = $dm->getRepository(comment::class)->findAll();

        return $this->render('admin/comments_dashboard.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/admin/comments/toggle/{id}', name: 'admin_toggle_comment')]
    public function toggleValidity(DocumentManager $dm, string $id): Response
    {
        $comment = $dm->getRepository(comment::class)->find($id);

        if (!$comment) {
            $this->addFlash('error', 'Comment not found');
            return $this->redirectToRoute('admin_comments');
        }

        // Toggle the validity
        $comment->setValidation(!$comment->getValidation());
        $dm->flush();

        $this->addFlash('success', 'Validité du commentaire mise à jour');
        return $this->redirectToRoute('admin_comments');
    }
}