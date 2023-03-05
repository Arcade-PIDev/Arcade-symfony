<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Evenement;
use App\Entity\Sponsor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use App\Form\AjouterEventType;
use App\Form\ModifierEventType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventsApiController extends AbstractController
{ 
  
    #[Route('/afficherEvent/api', name: 'app_afficher_Event_api')]
    public function afficherEvent(ManagerRegistry $doctrine,NormalizerInterface $normalizer)
    {
        $rep=$doctrine->getRepository(persistentObject:Evenement::class);
        $E=$rep->findAll();
        $jsonContent=$normalizer->normalize($E,'json',['groups'=>'E']);
        return new Response(json_encode($jsonContent));
       
    }

   
    #[Route('/ajouterEvent/api', name: 'app_ajouter_Event_api')]
        public function AddFormEventMaker(Request $request, ManagerRegistry $doctrine, NormalizerInterface $normalizer)
        {
            
            $em=$doctrine->getManager();
            $E=new Evenement();
          
            $E->setNomEvent($request->get('NomEvent'));
            $E->setLieu($request->get('lieu'));
            $E->setDateDebutE( new \DateTime ('DateDebutE'));
            $E->setDateFinE( new \DateTime ('DateFinE'));
            $E->setAfficheE($request->get('AfficheE'));
            $E->setPrixTicket($request->get('PrixTicket'));
            $E->setNbrPlaces($request->get('NbrPlaces'));
            $E->setDescriptionEvent($request->get('DescriptionEvent'));
           

                $em->persist($E);
                $em->flush();
                $jsonContent=$normalizer->normalize($E,'json',['groups'=>'E']);
               return new Response(json_encode($jsonContent));
           
        }

        #[Route('/supprimerEvent/api/{id}', name: 'app_supprimer_Event_api')]
        public function supprimerEventID (ManagerRegistry $doctrine, Evenement $E, NormalizerInterface $Normalizer)
        {   
            
            $em=$doctrine->getManager();
            $em->remove($E);
            $em->flush();
            $jsonContent=$Normalizer->normalize($E,'json',['groups'=>'E']);
    
            return new Response("Event deleted".json_encode($jsonContent));
           
           
        }
     
       

        #[Route('/modifierEvent/api/{id}', name: 'app_modifier_Event_api')]
        public function updateFormEventMaker(Request $request, NormalizerInterface $Normalizer, $id)
        { 
                $em = $this->getDoctrine()->getManager();
                $E = $em->getRepository(Evenement::class)->find($id);
                $E->setNomEvent($request->get('NomEvent'));
                $E->setLieu($request->get('lieu'));
                $E->setDateDebutE( new \DateTime ('DateDebutE'));
                $E->setDateFinE( new \DateTime ('DateFinE'));
                $E->setAfficheE($request->get('AfficheE'));
                $E->setPrixTicket($request->get('PrixTicket'));
                $E->setNbrPlaces($request->get('NbrPlaces'));
                $E->setDescriptionEvent($request->get('DescriptionEvent'));
                $em->persist($E);
                $em->flush();
    
                $jsonContent=$Normalizer->normalize($E,'json',['groups'=>'E']);
                return new Response(json_encode($jsonContent));
           
        }

    
          
        
}
