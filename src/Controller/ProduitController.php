<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Form\ProduitFormType;
use App\Form\UpdateProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;

class ProduitController extends AbstractController
{
    #[Route('/afficherProduit', name: 'app_afficherProduit')]
    public function afficherProduit(ProduitRepository $repo)
    {
        return $this->render('produit/afficherProduit.html.twig', [
            'produit' => $repo->findAll(),
        ]);
    }

    #[Route('/deleteProduit/{id}', name: 'app_deleteProduit')]
    public function deleteProduit(ManagerRegistry $doctrine,ProduitRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $cat=$repo->find($id);
        $manager->remove($cat);
        $manager->flush();
        return $this->redirectToRoute('app_afficherProduit');
    }

    #[Route('/ajouterProduit', name: 'app_ajouterProduit')]
    public function ajouterProduit(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $produit=new Produit();

        $form=$this->createForm(ProduitFormType::class, $produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setCreationDate(new \DateTime("now"));
            $produit->setModificationDate(null);

            $file = $request->files->get('produit_form')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('produit_directory'), $filename);
            $produit->setImage($filename);

            $produit->setIsEnabled(1);
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute('app_afficherProduit');
           }

        return new Response($twig->render('produit/ajouterProduit.html.twig',[
            'formProduit' => $form->createView()
        ]));
    }

    #[Route('/updateProduit/{id}', name: 'app_updateProduit')]
    public function updateProduit($id,Produit $produit,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateProduitType::class, $produit);
        $form->handleRequest($request);
        $produit->getImage();
        //$produit = $this->getDoctrine()->getRepository(Products::class)->find($id);
        $entityManager->getRepository(Produit::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setModificationDate(new \DateTime("now"));

            $file = $request->files->get('update_produit')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('produit_directory'), $filename);
            $produit->setImage($filename);

            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherProduit');
        }
/*
        $img=$produit->getImage();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('update_produit')['image'];
            if($files){
                $filenames = "";
                foreach ($files as $file) {
                    $filename = md5(uniqid()) . '.png';
                    $file->move($this->getParameter('produit_directory'), $filename);
                    $filenames .= $filename . "*";
                }
                $produit->setImage($filenames);
                //$entityManager->persist($produit);
                $entityManager->flush();
                return $this->redirect($this->generateUrl('productsshow'));
            }
            else
            {
                $produit->setImage($img);
                //$entityManager->persist($produit);
                $entityManager->flush();
                return $this->redirect($this->generateUrl('productsshow'));
            }*/
            //$product->setCreationDate(null);

        return $this->render('produit/modifierProduit.html.twig', [
            'formProd' => $form->createView(),
        ]);
    }



    //front
    #[Route('/afficherProduitFront/{cat}', name: 'app_afficherProduitFront')]
    public function afficherProduitFront(ProduitRepository $repo,$cat)
    {
        return $this->render('produit/afficherProduitFront.html.twig', [
            'produit' => $repo->findByCategorie($cat),
        ]);
    }

    #[Route('/detailProduitFront/{id}', name: 'app_detailProduitFront')]
    public function detailProduitFront(ProduitRepository $repo,$id)
    {
        return $this->render('produit/detailProduitFront.html.twig', [
            'produit' => $repo->find($id),
        ]);
    }

}
