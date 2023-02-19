<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Evenement;
use App\Entity\ParticipationEvenement;
// use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use App\Form\AjouterParticipEventType;


class ParticipationEventController extends AbstractController
{
   
    #[Route('/afficherparticipationEvent', name: 'app_afficherParticipation_event')]
    public function afficherParticipEvent(ManagerRegistry $doctrine)
    {
        $rep=$doctrine->getRepository(persistentObject:ParticipationEvenement::class);
        $list=$rep->findAll();
        return $this->render("participation_event/afficherParticipationsEvent.html.twig", ['listParticipEvents'=>$list]);
       
    }



    #[Route('/ajouterparticipationEvent', name: 'app_ajouterParticipation_Event')]
        public function AddFormPEventMaker(Request $request, ManagerRegistry $doctrine)
        {
            
            $em=$doctrine->getManager();
            $E=new ParticipationEvenement();
            $form=$this->createForm(AjouterParticipEventType::class, $E);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
              

                $em->persist($E);
                $em->flush();
                return $this->redirectToRoute('app_afficherParticipation_event');
                
            
               }
            
            return $this->renderForm("events/ajouterParticipationEvent.html.twig",array("form"=>$form));
             
           
        }

        #[Route('/supprimerparticipationEvent/{id}', name: 'app_supprimer_participationEvent')]
        public function supprimerEventID (ManagerRegistry $doctrine, ParticipationEvenement $E1)
        {   
            
            $em=$doctrine->getManager();
            $em->remove($E1);
            $em->flush();
            return $this->redirectToRoute('app_afficherParticipation_event');
           
           
        }
}
