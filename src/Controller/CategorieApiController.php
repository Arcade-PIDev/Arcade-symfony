<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File as FileFile;

class CategorieApiController extends AbstractController
{
    #[Route('/afficherCategorie/api', name: 'app_afficherCategorie_api')]
    public function afficherCategorie(CategorieRepository $repo,NormalizerInterface $normalizer): Response
    {
        $categorie=$repo->findAll();
        $jsonContent=$normalizer->normalize($categorie,'json',['groups'=>'post:read']);

        return new Response(json_encode($jsonContent));
    }
    
    #[Route('/ajouterCategorie/api', name: 'app_ajouterCategorie_api')]
    public function ajouterCategorie(Request $request,NormalizerInterface $normalizer,EntityManagerInterface $manager)
    {
        $categorie = new Categorie();

        $categorie->setNomCategorie($request->get('nomCategorie'));
        $categorie->setDescription($request->get('description'));
        $categorie->setImage($request->get("image"));
        $categorie->setCreationDate(new \DateTime("now"));
        $categorie->setModificationDate(null);
        $categorie->setIsEnabled(1);

        $manager->persist($categorie);
        $manager->flush();
            
        $jsonContent=$normalizer->normalize($categorie,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
        
    }
    #[Route('/deleteCategorie/api/{id}', name: 'app_deleteCategorie_api')]
    public function deleteCategorie(CategorieRepository $repo,NormalizerInterface $normalizer,$id,EntityManagerInterface $manager)
    {
        $cat=$repo->find($id);
        $manager->remove($cat);
        $manager->flush();
        $jsonContent=$normalizer->normalize($cat,'json',['groups'=>'post:read']);

        return new Response("categorie supprimée".json_encode($jsonContent));
    }

    #[Route('/updateCategorie/api/{id}', name: 'app_updateCategorie_api')]
    public function updateCategorie(EntityManagerInterface $manager,Request $request,NormalizerInterface $Normalizer,$id)
    {  
        
            $cat = $manager->getRepository(Categorie::class)->find($id);
            $cat->setNomCategorie($request->get('nomCategorie'));
            $cat->setDescription($request->get('description'));
            $cat->setImage($request->get('image'));  
            $cat->setIsEnabled(1);
            
            $manager->flush();

            $jsonContent=$Normalizer->normalize($cat,'json',['groups'=>'post:read']);
            return new Response(json_encode($jsonContent));
    }
}
