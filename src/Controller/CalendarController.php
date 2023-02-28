<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(EvenementRepository $calendar)
    {
        $events = $calendar->findAll();

        $rdvs = [];                           

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'title' => $event->getNomEvent(),
                'start' => $event->getDateDebutE()->format('Y-m-d H:m:s')?? '',
                'end' => $event->getDateFinE()->format('Y-m-d H:m:s')?? '',
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->isAllDay(),
                
                
               
            ];
        }

        $data = json_encode($rdvs);


        return $this->render('calendar/index.html.twig', compact('data'));
    }

}
