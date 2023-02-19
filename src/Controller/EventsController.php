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

class EventsController extends AbstractController
{ 
   /* #[Route('/events', name: 'app_events')]
    public function index(): Response
    {
        return $this->render('events/index.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }*/
    

    #[Route('/afficherEvent', name: 'app_afficher_Event')]
    public function afficherEvent(ManagerRegistry $doctrine)
    {
        $rep=$doctrine->getRepository(persistentObject:Evenement::class);
        $list=$rep->findAll();
        return $this->render("Events/afficherBackEvent.html.twig", ['listEvents'=>$list]);
       
    }

    #[Route('/afficherFrontEvent', name: 'app_afficherFront_Event')]
    public function afficherFrontEvent(ManagerRegistry $doctrine)
    {
        $rep=$doctrine->getRepository(persistentObject:Evenement::class);
        $list=$rep->findAll();
        return $this->render("events/afficherFrontEvent.html.twig", ['listEvents'=>$list]);
       
    }


    #[Route('/ajouterEvent', name: 'app_ajouter_Event')]
        public function AddFormEventMaker(Request $request, ManagerRegistry $doctrine)
        {
            
            $em=$doctrine->getManager();
            $E=new Evenement();
            $form=$this->createForm(AjouterEventType::class, $E);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
              
            
             $file = $request->files->get('ajouter_event')['AfficheE'];
             $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('event_directory'), $filename);
            $E->setAfficheE($filename);

                $em->persist($E);
                $em->flush();
                return $this->redirectToRoute('app_afficher_Event');
                
            
               }
            
            return $this->renderForm("events/ajouterEvent.html.twig",array("form"=>$form));
             
           
        }

        #[Route('/supprimerEvent/{id}', name: 'app_supprimer_Event')]
        public function supprimerEventID (ManagerRegistry $doctrine, Evenement $E1)
        {   
            
            $em=$doctrine->getManager();
            $em->remove($E1);
            $em->flush();
            return $this->redirectToRoute('app_afficher_Event');
           
           
        }
    
        #[Route('/modifierEvent/{id}', name: 'app_modifier_Event')]
        public function updateFormEventMaker(Request $request, ManagerRegistry $doctrine,$id)
        {
            //$id=$request->get('id'); instead of $id as parameter
            $rep=$doctrine->getRepository(persistentObject:Evenement::class);
            $Ev=$rep->find($id);
            $form=$this->createForm(ModifierEventType::class, $Ev);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $request->files->get('modifier_event')['AfficheE'];
                $filename = md5(uniqid()) . '.png';
                $file->move($this->getParameter('event_directory'), $filename);
                $Ev->setAfficheE($filename);
              
                $em=$doctrine->getManager();
                $em->persist($Ev);
                $em->flush();
                return $this->redirectToRoute('app_afficher_Event');
               }
            
            return $this->renderForm("events/modifierEvent.html.twig",array("form"=>$form));}
    

}
