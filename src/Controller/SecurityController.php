<?php

namespace App\Controller;

use App\Form\RequestPasswordFormType;
use App\Form\ResetPasswordFormType;
use App\Repository\UserRepository;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/forgotten-password', name: 'app_forgotten_password')]
    public function forgottenPasword(
        Request $request,
        UserRepository $userRepository,
        JWTService $jwt,
        SendMailService $mail
    ) : Response {
        $form=$this->createForm(RequestPasswordFormType::class);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $userRepository->findOneByEmail([$form->get('email')->getData()]);
        
            if($user){
                //On a un utilisateur
                //On gnere un JWT
                $heather = ['alg'=>'HS256','typ'=>'JWT'];
                $payload = ['user_id'=>$user->getId(),'exp'=>time()+3600];
        
                $token = $jwt->generate($heather,$payload,$this->getParameter('app.jwt_secret'));
        
                //On genere l'URL vers reset-password
                $url = $this->generateUrl('app_reset_password',['token'=>$token],
                UrlGeneratorInterface::ABSOLUTE_URL);

                //On envoie un email
                $mail->send(
                    'arcadia@zoo.com',
                    $user->getEmail(),
                    'Réinitialisation de votre mot de passe',
                    'password_reset',
                    compact('user','url') //['user'=>$user,'url'=>$url]
                );

                $this->addFlash('success','Email envoyé');
                return $this->redirectToRoute('app_login');
            }
            $this->addFlash('danger','Un problem est survenu');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig',[
            'requestPassForm'=>$form->createView()
        ]);
    }

    #[Route(path: '/forgotten-password/{token}', name: 'app_reset_password')]
    public function resetPassword(
        $token,         
        JWTService $jwt,
        UserRepository $userRepository,
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ) : Response {
    // Validate the JWT token
    if (!$jwt->isValid($token) || $jwt->isExpired($token) || !$jwt->checkSignature($token, $this->getParameter('app.jwt_secret'))) {
        $this->addFlash('danger', 'Token invalide ou expiré');
        return $this->redirectToRoute('app_login');
    }

    // Get the payload (which includes user_id)
    $payload = $jwt->getPayload($token);

    // Fetch the user by the user_id from the payload
    if (!isset($payload['user_id'])) {
        $this->addFlash('danger', 'Le jeton ne contient pas d\'identifiant utilisateur valide.');
        return $this->redirectToRoute('app_login');
    }

    $user = $userRepository->find($payload['user_id']);
    if (!$user) {
        $this->addFlash('danger', 'Utilisateur introuvable.');
        return $this->redirectToRoute('app_login');
    }

    // Create the form for password reset
    $form = $this->createForm(ResetPasswordFormType::class);
    $form->handleRequest($request);

    // If the form is submitted and valid, update the user's password
    if ($form->isSubmitted() && $form->isValid()) {
        $newPassword = $form->get('password')->getData();
        $user->setPassword(
            $passwordHasher->hashPassword($user, $newPassword)
        );

        // Save the new password
        $em->flush();

        // Flash message and redirect to login
        $this->addFlash('success', 'Mot de passe modifié avec succès.');
        return $this->redirectToRoute('app_login');
    }

    // Render the password reset form
    return $this->render('security/new_password.html.twig', [
        'newPasswordForm' => $form->createView()
    ]);
    }
}