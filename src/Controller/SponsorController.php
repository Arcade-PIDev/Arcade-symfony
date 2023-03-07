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
use App\Form\AjouterSponsorType;
use App\Form\ModifierSponsorType;
use App\Repository\SponsorRepository;

class SponsorController extends AbstractController
{
    /*#[Route('/sponsor', name: 'app_sponsor')]
    public function index(): Response
    {
        return $this->render('sponsor/index.html.twig', [
            'controller_name' => 'SponsorController',
        ]);
    }*/

    #[Route('/afficherSponsor', name: 'app_afficher_Sponsor')]
    public function afficherSponsor(ManagerRegistry $doctrine)
    {
        $rep=$doctrine->getRepository(persistentObject:Sponsor::class);
        $list=$rep->findAll();
        return $this->render("sponsor/afficherBackSponsor.html.twig", ['listSponsors'=>$list]);
       
    }
       

    #[Route('/afficherFrontSponsor/{e}', name: 'app_afficherFront_Sponsor')]
    public function afficherSponsorFront(SponsorRepository $repo,$e)
    {
        return $this->render('sponsor/afficherFrontSponsor.html.twig', [
            'listSponsors' => $repo->findByIDEventsFK($e),
        ]);
    }
   

   

    #[Route('/ajouterSponsor', name: 'app_ajouter_Sponsor')]
        public function AddFormSponsorMaker(Request $request, ManagerRegistry $doctrine)
        {
            
            $em=$doctrine->getManager();
            $S=new Sponsor();
            $form=$this->createForm(AjouterSponsorType::class, $S);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $request->files->get('ajouter_sponsor')['logoSponsor'];
                $filename = md5(uniqid()) . '.png';
                $file->move($this->getParameter('sponsor_directory'), $filename);
                $S->setlogoSponsor($filename);
            
                $em->persist($S);
                $em->flush();
                return $this->redirectToRoute('app_afficher_Sponsor');
                
            
               }
            
            return $this->renderForm("sponsor/ajouterSponsor.html.twig",array("form"=>$form));
             
           
        }

        #[Route('/supprimerSponsor/{id}', name: 'app_supprimer_Sponsor')]
        public function supprimerSponsorID (ManagerRegistry $doctrine, Sponsor $S1)
        {   
            
            $em=$doctrine->getManager();
            $em->remove($S1);
            $em->flush();
    
            return $this->redirectToRoute('app_afficher_Sponsor');
           
        }
    
        #[Route('/modifierSponsor/{id}', name: 'app_modifier_Sponsor')]
        public function updateFormSponsorMaker(Request $request, ManagerRegistry $doctrine,$id)
        {
            //$id=$request->get('id'); instead of $id as parameter
            $rep=$doctrine->getRepository(persistentObject:Sponsor::class);
            $Sp=$rep->find($id);
            $form=$this->createForm(ModifierSponsorType::class, $Sp);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $request->files->get('modifier_sponsor')['logoSponsor'];
                $filename = md5(uniqid()) . '.png';
                $file->move($this->getParameter('sponsor_directory'), $filename);
                $Sp->setlogoSponsor($filename);
                $em=$doctrine->getManager();
                $em->persist($Sp);
                $em->flush();
                return $this->redirectToRoute('app_afficher_Sponsor');
    
               }
            
            return $this->renderForm("sponsor/modifierSponsor.html.twig",array("form"=>$form));}
    
            #[Route('/map/{id}', name: 'app_map')]
            public function index(SponsorRepository $repo,$id)
            {
                return $this->render('sponsor/newMap.html.twig', [
                    'listSponsors' => $repo->findById($id),
                ]);
            }

            
           
           

}
