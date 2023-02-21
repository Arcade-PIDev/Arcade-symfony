<?php

namespace App\Controller;


use App\Repository\ParticipationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ParticipationsFormType;
use App\Form\UpdateParticipationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Participations;
use Doctrine\Persistence\ManagerRegistry;

class ParticipationsController extends AbstractController
{
    #[Route('/afficherParticipations', name: 'app_afficherParticipations')]
    public function afficherParticipations(ParticipationsRepository $repo)
    {
        return $this->render('Participations/afficherParticipations.html.twig', [
            'Participations' => $repo->findAll(),
        ]);
    }

    #[Route('/ajouterParticipations', name: 'app_ajouterParticipations')]
    public function ajouterParticipations(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $Participations=new Participations();

        $form=$this->createForm(ParticipationsFormType::class, $Participations);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           

            $manager->persist($Participations);
            $manager->flush();
            return $this->redirectToRoute('app_afficherParticipations');
           }

        return new Response($twig->render('Participations/ajouterParticipations.html.twig',[
            'formParticipations' => $form->createView()
        ]));
    }

    #[Route('/deleteParticipations/{id}', name: 'app_deleteParticipations')]
    public function deleteParticipations(ManagerRegistry $doctrine,ParticipationsRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $Par=$repo->find($id);
        $manager->remove($Par);
        $manager->flush();
        return $this->redirectToRoute('app_afficherParticipations');
    }

    #[Route('/updateParticipations/{id}', name: 'app_updateParticipations')]
    public function updateParticipations($id,Participations $Participations,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateParticipationsType::class, $Participations);
        $form->handleRequest($request);
        
        $entityManager->getRepository(Participations::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($Participations);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherParticipations');
        }

        return $this->render('Participations/modifierParticipations.html.twig', [
            'formParticipations' => $form->createView(),
        ]);
    }   
}

