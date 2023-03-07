<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Commande;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\qrCodeService;

class CommandeController extends AbstractController
{
    #[Route('/afficherCommande/{id}', name: 'app_afficherCommande')]
    public function index(CommandeRepository $repo, ProduitRepository $product,$id,SessionInterface $session,qrCodeService $qrcodeserv): Response
    {
        $commande = $repo->find($id);
        $myCart = $session->get('panier', []);

        foreach ($myCart as $id => $quantite) {
            $productCart[] = [
                'produit' => $product->find($id),
                'quantite' => $quantite
            ];
        }
        
        $data = "Voici votre commande:\n" . "Num Commande: ".$commande->getId().
        "\nPrix total de la commande: ".$commande->getPrixTotal()."DT";
        $qrCode = $qrcodeserv->qrcode($data);
        
        return $this->render('commande/afficherCommande.html.twig', [
            'commande' => $commande,
            'produits' => $productCart,
            'qrCode'=>$qrCode,
            'user' => $this->getUser(),
        ]); 

    }

    #[Route('/myOrders/{user}', name: 'app_myOrders')]
    public function myOrders(CommandeRepository $repo, $user): Response
    {
        $orders = $repo->findByUsers($user);
        $productOrdered = [];
        foreach ($orders as $order) {
            $productOrdered[] = [
                'order' => $order,
            ];
        }

        return $this->render('commande/myOrders.html.twig', [
            'productOrdered' => $productOrdered,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/ajouterCommande', name: 'app_ajouterCommande')]
    public function ajouterCommande(SessionInterface $session, ProduitRepository $repo,EntityManagerInterface $manager)
    {
        $commande = new Commande();

        $myCart = $session->get('panier', []);

        $total = 0;
        foreach ($myCart as $id => $quantity) {
            $product = $repo->find($id);
            if ($product->getQuantiteStock() >= $quantity) {

                $panier = new Panier();
                $panier->setProduits($repo->find($id));
                $panier->setQuantite($quantity);
                $commande->setUsers($this->getUser());
                $product->setQuantiteStock($product->getQuantiteStock() - $quantity);

                $total += $repo->find($id)->getPrix() * $quantity;

                $manager->persist($panier);
                $commande->addpanier($panier);
            }
            else {
                return $this->redirectToRoute("app_afficherPanier");
            }
        }

        $commande->setIsCanceled(0);
        $commande->setPrixTotal($total);
        $commande->setIsPaid(1);
        $commande->setUsers($this->getUser());
        $manager->persist($commande);
        $manager->flush();
        $id = $commande->getId();
        
   

        return $this->redirectToRoute("app_afficherCommande", [
            'id' => $id,
            'user' => $this->getUser(),
        ]);

    }

    #[Route('/cancelOrder/{id}', name: 'app_cancelOrder')]
    public function cancelOrder($id,CommandeRepository $repo,EntityManagerInterface $manager)
    {
        $order = $repo->find($id);
        $order->setIsCanceled(1);
        $manager->flush();


        return $this->redirectToRoute("app_afficherPanier");
    }

    #[Route('/afficherCommandeBack', name: 'app_afficherCommandeBack')]
    public function afficherCommandeBack(CommandeRepository $repo)
    {
        return $this->render('commande/afficherCommandeBack.html.twig', [
            'commande' => $repo->findAll(),
            'user' => $this->getUser(),
        ]);

    }

    #[Route('/deleteCommande/{id}', name: 'app_deleteCommande')]
    public function deleteCommande(EntityManagerInterface $manager,CommandeRepository $repo,$id)
    {
        $order=$repo->find($id);
        $manager->remove($order);
        $manager->flush();
        return $this->redirectToRoute('app_afficherCommandeBack');
    }
}
