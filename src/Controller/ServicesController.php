<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(
        ScheduleRepository $scheduleRepository,
    ): Response
    {
        $formattedSchedules = $scheduleRepository->getFormattedSchedules();


        return $this->render('pages/services.html.twig', [
            'controller_name' => 'ServicesController',
            'schedules'=>$formattedSchedules,
            'title'=>'Services'
        ]);
    }
}
