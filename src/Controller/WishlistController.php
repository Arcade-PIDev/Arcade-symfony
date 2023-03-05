<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Wishlist;
use App\Repository\ProduitRepository;
use App\Repository\WishlistRepository;
use Doctrine\ORM\EntityManagerInterface;

class WishlistController extends AbstractController
{
    #[Route('/wishlist', name: 'app_wishlist')]
    public function index(ProduitRepository $repo,WishListRepository $repoWishList): Response
    {
        $liste = [];

        foreach ($repoWishList as $item) {
          
                $liste[] = [
                    'produit' => $item->getProduits(),
                ];
        }
   
        return $this->render('wishlist/index.html.twig', [
            'liste'=>$repoWishList->findAll()
        ]);
    }

    #[Route('/addWishlist/{id}', name: 'app_addWishlist')]
    public function addWishlist($id,ProduitRepository $repo,WishListRepository $repoWishList,EntityManagerInterface $manager)
    {
        $produit = $repo->find($id);
       
        if($repoWishList->findByProduct($produit))
        {  
            $wishlist= $repoWishList->findByProduct($produit);
            $manager->remove($wishlist);
            $manager->flush();
        }
        else{
           
            $wishlist = new Wishlist();
            $wishlist->setProduits($repo->find($id));
            $manager->persist($wishlist);
            $manager->flush();
      
        }
        return $this->redirectToRoute('app_wishlist');
        
    }
}