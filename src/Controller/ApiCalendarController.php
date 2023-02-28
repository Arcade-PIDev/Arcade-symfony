<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use DateTime;

class ApiCalendarController extends AbstractController
{ 
    
    #[Route('/api/{id}/edit', name: 'api_event_edit', methods: ['PUT'])]
  
    public function majEvent(?Evenement $calendar, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->NomEvent) && !empty($donnees->NomEvent) &&
           
            isset($donnees->DateDebutE) && !empty($donnees->DateDebutE) &&
            isset($donnees->background_Color) && !empty($donnees->background_Color) &&
            isset($donnees->border_Color) && !empty($donnees->border_Color) &&
            isset($donnees->text_Color) && !empty($donnees->text_Color) 
           

        )
        
        { 
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new Evenement;

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $calendar->setNomEvent($donnees->NomEvent);
           
            $calendar->setDateDebutE(new DateTime($donnees->DateDebutE));
            if($donnees->all_Day){
                $calendar->setDateFinE(new DateTime($donnees->DateDebutE));
            }else{
                $calendar->setDateFinE(new DateTime($donnees->DateFinE));
            }
            $calendar->setAllDay($donnees->all_Day);
            $calendar->setBackgroundColor($donnees->background_Color);
            $calendar->setBorderColor($donnees->border_Color);
            $calendar->setTextColor($donnees->text_Color);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            // On retourne le code
            return new Response('Ok', $code);
        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }


        return $this->render('api_calendar/index.html.twig', [
            'controller_name' => 'ApiCalendarController',
        ]);
    }
}

