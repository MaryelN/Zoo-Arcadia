<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\AnimalReport;
use App\Entity\FoodReport;
use App\Entity\Habitat;
use App\Entity\Image;
use App\Entity\Race;
use App\Entity\Schedule;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]

    public function index(): Response
    {
        
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('admin/dashboard.html.twig');
    }
        
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('Arcadia Zoo - Admin')
        ->renderContentMaximized();
    }
    
    public function configureMenuItems(): iterable
    {
        $menuItems[] = MenuItem::linkToRoute('Retour au Site', 'fa fa-home', 'app_index');
        $menuItems[] = MenuItem::section('Site Arcadia Zoo');
        $menuItems[] = MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    
        if ($this->isGranted('ROLE_ADMIN')) {
            $menuItems[] = MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
            $menuItems[] = MenuItem::linkToRoute('Registrer un utilisateur', 'fa fa-user', 'app_register');
            $menuItems[] = MenuItem::linkToCrud('Horaires', 'fa fa-clock', Schedule::class);
            $menuItems[] = MenuItem::linkToCrud('Animaux', 'fa-solid fa-paw', Animal::class);
            $menuItems[] = MenuItem::linkToCrud('Images', 'fa-solid fa-camera', Image::class);
            $menuItems[] = MenuItem::linkToCrud('Habitats', 'fa-brands fa-pagelines', Habitat::class);
            $menuItems[] = MenuItem::linkToCrud('Race', 'fa-solid fa-hippo', Race::class);
            $menuItems[] = MenuItem::linkToRoute('Avis', 'fa-solid fa-comment', 'admin_comments');
            $menuItems[] = MenuItem::section('Reports');
            $menuItems[] = MenuItem::linkToCrud('Reports Norriture', 'fa-solid fa-drumstick-bite', FoodReport::class);
            $menuItems[] = MenuItem::linkToCrud('Reports Veterinaire', 'fa-solid fa-shield-dog', AnimalReport::class);
        } elseif ($this->isGranted('ROLE_VETERINARY')) {
            $menuItems[] = MenuItem::section('Reports');
            $menuItems[] = MenuItem::linkToCrud('Reports Norriture', 'fa-solid fa-drumstick-bite', FoodReport::class);
            $menuItems[] = MenuItem::linkToCrud('Reports Veterinaire', 'fa-solid fa-shield-dog', AnimalReport::class);
        } elseif ($this->isGranted('ROLE_USER')) {
            $menuItems[] = MenuItem::linkToCrud('Animaux', 'fa-solid fa-paw', Animal::class);
            $menuItems[] = MenuItem::linkToCrud('Images', 'fa-solid fa-camera', Image::class);
            $menuItems[] = MenuItem::linkToCrud('Habitats', 'fa-brands fa-pagelines', Habitat::class);
            $menuItems[] = MenuItem::linkToCrud('Race', 'fa-solid fa-hippo', Race::class);
            $menuItems[] = MenuItem::linkToRoute('Avis', 'fa-solid fa-comment', 'admin_comments');
            $menuItems[] = MenuItem::section('Reports');
            $menuItems[] = MenuItem::linkToCrud('Reports Norriture', 'fa-solid fa-drumstick-bite', FoodReport::class);
        }
        
        return $menuItems;
    }
}
