<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class RegistrationController extends AbstractController
{

    private EmailVerifier $emailVerifier;

    // Inject the EmailVerifier into the constructor
    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        EntityManagerInterface $entityManager,
        SendMailService $sendMailService
        ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the selected role
            $selectedRole = $form->get('roles')->getData();
            $user->setRoles([$selectedRole]);  

            // encode the plain password
            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $context = [
                'user' => $user,
            ];

            try {
                $sendMailService->send(
                        'arcadia@zoo.com',
                        // 'arcadia@zoo.com', TESTING
                        $user->getEmail(),
                        'Test Email: Veuillez confirmer votre Email',
                        'confirmation_email',
                        $context
                );
            
                $this->addFlash('success', 'L\'enregistrement a été effectué avec succès, un email de vérification a été envoyé!');
                
            } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                $this->addFlash('error', 'Il y a eu un problème lors de l\'envoi de l\'e-mail de verification.');
                error_log($e->getMessage()); 
            }

            return $this->redirectToRoute('admin');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
            'title' => 'Inscription',
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request $request, 
        TranslatorInterface $translator
        ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            // Handle email verification
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    
            // Add a success flash message and redirect to a proper route after verification
            $this->addFlash('success', 'Votre adresse e-mail a été vérifiée avec succès.');
            return $this->redirectToRoute('admin'); // Redirect to main dashboard after success
    
        } catch (VerifyEmailExceptionInterface $exception) {
            // Handle verification errors (invalid/expired token)
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
    
            return $this->redirectToRoute('app_register');  // Redirect to register page if there's an error
        }
    }

    #[Route('/resend-verification', name: 'app_resend')]
    public function resendVerification(
        Request $request,
        SendMailService $sendMailService
        ): Response {
        // Get the currently authenticated user
        $user = $this->getUser(); 
    
        // Check if the user is authenticated
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour demander un nouvel email de vérification.');
            return $this->redirectToRoute('app_login'); // Redirect to login if not authenticated
        }
    
        if (!$user->isVerified()) {
            $email = (new TemplatedEmail())
            ->from('arcadia@zoo.com')
            ->to($user->getEmail())
            ->subject('Veuillez confirmer votre Email')
            ->htmlTemplate('emails/confirmation_email.html.twig');

            // Call the EmailVerifier to send the verification email
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email', // The route name for email verification
                $user,              // The user object
                $email              // The templated email object
            );
    
            $this->addFlash('success', 'Un nouveau lien de vérification a été envoyé à votre adresse email.');
        } else {
            // If the user is already verified
            $this->addFlash('warning', 'Votre compte est déjà vérifié.');
        }
    
        return $this->redirectToRoute('admin');  // Redirect to your main dashboard
    }
}
