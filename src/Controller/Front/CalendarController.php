<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendrier', name: 'app_front_calendar')]
    public function index(): Response
    {
        return $this->render('front/calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
        ]);
    }
}
