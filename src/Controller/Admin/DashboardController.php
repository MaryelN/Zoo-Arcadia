<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\AnimalReport;
use App\Entity\Comment;
use App\Entity\FoodReport;
use App\Entity\Habitat;
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
    
        if ($this->isGranted('ROLE_ADMIN')) {
            $menuItems[] = MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
            $menuItems[] = MenuItem::linkToCrud('Horaires', 'fa fa-clock', Schedule::class);
        }
        
        $MenuItem[] = MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        $menuItems[] = MenuItem::linkToCrud('Animaux', 'fas fa-list', Animal::class);
        $menuItems[] = MenuItem::linkToCrud('Habitats', 'fas fa-list', Habitat::class);
        $menuItems[] = MenuItem::linkToCrud('Avis', 'fa fa-list', Comment::class);
        
        $menuItems[] = MenuItem::section('Reports');
        $menuItems[] = MenuItem::linkToCrud('Reports Veterinaire', 'fa fa-list', AnimalReport::class);
        $menuItems[] = MenuItem::linkToCrud('Reports Norriture', 'fa fa-list', FoodReport::class);
        
        return $menuItems;
    }
}
