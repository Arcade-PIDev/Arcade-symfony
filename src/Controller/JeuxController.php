<?php

namespace App\Controller;

use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\JeuxFormType;
use App\Form\UpdatejeuxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Jeux;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\File;
class JeuxController extends AbstractController
{
    #[Route('/afficherjeux', name: 'app_afficherjeux')]
    public function afficherjeux(jeuxRepository $repo)
    {
        return $this->render('jeux/afficherjeux.html.twig', [
            'Jeux' => $repo->findAll(),
        ]);
    }

    #[Route('/ajouterjeux', name: 'app_ajouterjeux')]
    public function ajouterjeux(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $Jeux=new Jeux();

        $form=$this->createForm(JeuxFormType::class, $Jeux);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('jeux_form')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('Jeux_directory'), $filename);
            $Jeux->setImage($filename);
            $manager->persist($Jeux);
            $manager->flush();
            return $this->redirectToRoute('app_afficherjeux');
           }

        return new Response($twig->render('jeux/ajouterjeux.html.twig',[
            'formJeux' => $form->createView()
        ]));
    }

    #[Route('/deletejeux/{id}', name: 'app_deletejeux')]
    public function deletejeux(ManagerRegistry $doctrine,JeuxRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $Jeu=$repo->find($id);
        $manager->remove($Jeu);
        $manager->flush();
        return $this->redirectToRoute('app_afficherjeux');
    }

    #[Route('/updatejeux/{id}', name: 'app_updatejeux')]
    public function updatejeux($id,Jeux $Jeux,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdatejeuxType::class, $Jeux);
        $form->handleRequest($request);
        
        $entityManager->getRepository(Jeux::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('updatejeux')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('Jeux_directory'), $filename);
            $Jeux->setImage($filename);
            $entityManager->persist($Jeux);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherjeux');
        }

        return $this->render('jeux/modifierjeux.html.twig', [
            'formJeux' => $form->createView(),
        ]);
    }
     ///front///
     #[Route('/afficherJeuxFront', name: 'app_afficherJeuxFront')]
     public function afficherJeuxFront(JeuxRepository $repo)
     {
         return $this->render('jeux/afficherJeuxFront.html.twig', [
             'Jeux' => $repo->findAll(),
         ]);
     }
}
