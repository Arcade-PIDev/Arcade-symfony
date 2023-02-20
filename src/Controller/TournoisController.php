<?php

namespace App\Controller;

use App\Repository\TournoisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TournoisFormType;
use App\Form\UpdateTournoisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Tournois;
use Doctrine\Persistence\ManagerRegistry;

class TournoisController extends AbstractController
{
    #[Route('/afficherTournois', name: 'app_afficherTournois')]
    public function afficherTournois(TournoisRepository $repo)
    {
        return $this->render('Tournois/afficherTournois.html.twig', [
            'Tournois' => $repo->findAll(),
        ]);
    }
   

    #[Route('/ajouterTournois', name: 'app_ajouterTournois')]
    public function ajouterTournois(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $Tournois=new Tournois();

        $form=$this->createForm(TournoisFormType::class, $Tournois);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($Tournois);
            $manager->flush();
            return $this->redirectToRoute('app_afficherTournois');
           }

        return new Response($twig->render('Tournois/ajouterTournois.html.twig',[
            'formTournois' => $form->createView()
        ]));
    }

    #[Route('/deleteTournois/{id}', name: 'app_deleteTournois')]
    public function deleteTournois(ManagerRegistry $doctrine,TournoisRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $Tou=$repo->find($id);
        $manager->remove($Tou);
        $manager->flush();
        return $this->redirectToRoute('app_afficherTournois');
    }

    #[Route('/updateTournois/{id}', name: 'app_updateTournois')]
    public function updateTournois($id,Tournois $Tournois,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateTournoisType::class, $Tournois);
        $form->handleRequest($request);
        
        $entityManager->getRepository(Tournois::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($Tournois);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherTournois');
        }

        return $this->render('Tournois/modifierTournois.html.twig', [
            'formTournois' => $form->createView(),
        ]);
    }
     ///front///
     #[Route('/afficherTournoisFront', name: 'app_afficherTournoisFront')]
     public function afficherTournoisFront(TournoisRepository $repo)
     {
         return $this->render('Tournois/afficherTournoisFront.html.twig', [
             'Tournois' => $repo->findAll(),
         ]);
     }
}
