<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{
    #[Route('/afficherPanier', name: 'app_afficherPanier')]
    public function afficherPanier(ProduitRepository $repo,SessionInterface $session)
    {
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
            $total += $item['produit']->getPrix() * $item['quantite'];
        }


        return $this->render('panier/index.html.twig', [
            'dataPanier' =>  $dataPanier,
            'total' => $total,
        ]);
    }

    
    #[Route('/ajouterPanier/{id}', name: 'app_ajouterPanier')]
    public function ajouterPanier($id,ProduitRepository $repo,SessionInterface $session,EntityManagerInterface $manager)
    {
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else
        $panier[$id]=1;

        $session->set('panier', $panier);

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

    #[Route('/viderPanier', name: 'app_viderPanier')]
    public function viderPanier(SessionInterface $session)
    {
        $session->clear();

        return $this->redirectToRoute("app_afficherCategorieFront");
    }
}
