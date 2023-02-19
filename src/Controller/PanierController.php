<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PanierFormType;
use App\Entity\Produit;
use App\Entity\Panier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{
    #[Route('/afficherPanier', name: 'app_afficherPanier')]
    public function afficherPanier(ProduitRepository $repo,SessionInterface $session)
    {
        // $panier = $session->get("panier", []);

        // $dataPanier = [];

        // $total = 0;
        // foreach ($panier as $id => $quantite) {
        //     $product = $repo->find($id);
        //     $dataPanier = [
        //         "product" => $product,
        //         "quantite" => $quantite
        //     ];
        //     $total += $product->getPrix() * $quantite;
        // }
        // return $this->render('panier/index.html.twig', compact("dataPanier", "total"));

        $panier = $session->get('panier', []);
        $dataPanier = [];
        foreach ($panier as $id => $quantite) {
            $dataPanier[] = [
                'produit' => $repo->find($id),
                'quantite' => $quantite

            ];
        }

        $total = 0;
        foreach ($dataPanier as $item) {
            $totalItem = $item['produit']->getPrix() * $item['quantite'];
            $total += $totalItem;
        }


        return $this->render('panier/index.html.twig', [
            'dataPanier' =>  $dataPanier,
            'total' => $total,
            //'user' => $this->getUser()
        ]);
    }

    
    #[Route('/ajouterPanier/{id}', name: 'app_ajouterPanier')]
    public function ajouterPanier($id,ProduitRepository $repo,SessionInterface $session,EntityManagerInterface $manager)
    {
        $panier = $session->get("panier", []);
        //$id = $produit->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_afficherPanier");

    }

    #[Route('/remove/{id}', name: 'app_remove')]
    public function remove(SessionInterface $session, $id)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);


        return $this->redirectToRoute("app_afficherPanier");
    }
    
    #[Route('/moins/{id}', name: 'app_moins')]
    public function moins(SessionInterface $session, $id)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id]) && $panier[$id]!=1 ) {
            $panier[$id]--;
        } 
        $session->set('panier', $panier);

        return $this->redirectToRoute("app_afficherPanier");
    }
       
    #[Route('/plus/{id}', name: 'app_plus')]
    public function plus(SessionInterface $session, $id)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("app_afficherPanier");
    }
}
