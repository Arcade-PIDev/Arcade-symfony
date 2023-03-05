<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategorieFormType;
use App\Form\UpdateCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;

class CategorieController extends AbstractController
{
    #[Route('/afficherCategorie', name: 'app_afficherCategorie')]
    public function afficherCategorie(CategorieRepository $repo)
    {
        return $this->render('categorie/afficherCategorie.html.twig', [
            'categorie' => $repo->findAll(),
        ]);
    }

    #[Route('/ajouterCategorie', name: 'app_ajouterCategorie')]
    public function ajouterCategorie(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $categorie=new Categorie();

        $form=$this->createForm(CategorieFormType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setCreationDate(new \DateTime("now"));
            $categorie->setModificationDate(null);

            $file = $request->files->get('categorie_form')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('categorie_directory'), $filename);
            $categorie->setImage($filename);

            $categorie->setIsEnabled(1);
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute('app_afficherCategorie');
           }

        return new Response($twig->render('categorie/ajouterCategorie.html.twig',[
            'formCategorie' => $form->createView()
        ]));
    }

    #[Route('/deleteCategorie/{id}', name: 'app_deleteCategorie')]
    public function deleteCategorie(ManagerRegistry $doctrine,CategorieRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $cat=$repo->find($id);
        $manager->remove($cat);
        $manager->flush();
        return $this->redirectToRoute('app_afficherCategorie');
    }

    #[Route('/updateCategorie/{id}', name: 'app_updateCategorie')]
    public function updateCategorie($id,Categorie $categorie,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateCategorieType::class, $categorie);
        $form->handleRequest($request);
        $img=$categorie->getImage();
        $entityManager->getRepository(Categorie::class)->find($id);
        $categorie->setImage($img);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setModificationDate(new \DateTime("now"));
            $file = $request->files->get('update_categorie')['image'];
            if ($file)
            {
                $filename = md5(uniqid()) . '.png';
                $file->move($this->getParameter('categorie_directory'), $filename);
                $categorie->setImage($filename);
                $entityManager->persist($categorie);
                $entityManager->flush();
                return $this->redirectToRoute('app_afficherCategorie');
            }
            else
            {
                $categorie->setImage($img);
                $entityManager->persist($categorie);
                $entityManager->flush();
                return $this->redirectToRoute('app_afficherCategorie');

            }
            
        }
        return $this->render('categorie/modifierCategorie.html.twig', [
            'formCategorie' => $form->createView(),
        ]);
    }


    ///front///
    #[Route('/afficherCategorieFront', name: 'app_afficherCategorieFront')]
    public function afficherCategorieFront(CategorieRepository $repo)
    {
        return $this->render('categorie/afficherCategorieFront.html.twig', [
            'categorie' => $repo->findAll(),
        ]);
    }
    
}
