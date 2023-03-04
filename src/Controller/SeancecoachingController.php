<?php

namespace App\Controller;


use App\Repository\SeancecoachingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SeancecoachingFormType;
use App\Form\UpdateSeancecoachingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Seancecoaching;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
class SeancecoachingController extends AbstractController
{
    #[Route('/afficherSeancecoaching', name: 'app_afficherSeancecoaching')]
    public function afficherSeancecoaching(SeancecoachingRepository $repo)
    {
        return $this->render('Seancecoaching/test.html.twig', [
            'Seancecoaching' => $repo->findAll(),
        ]);
    }
   

    #[Route('/ajouterSeancecoaching', name: 'app_ajouterSeancecoaching')]
    public function ajouterSeancecoaching(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $Seancecoaching=new Seancecoaching();

        $form=$this->createForm(SeancecoachingFormType::class, $Seancecoaching);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $file = $request->files->get('seancecoaching_form')['imageSeance'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('imagesnada_directory'), $filename);
            $Seancecoaching->setImageSeance($filename);
           
            $manager->persist($Seancecoaching);
            $manager->flush();
            return $this->redirectToRoute('app_afficherSeancecoaching');
           }

        return new Response($twig->render('Seancecoaching/ajouterSeancecoaching.html.twig',[
            'formSeancecoaching' => $form->createView()
        ]));
    }

    #[Route('/deleteSeancecoaching/{id}', name: 'app_deleteSeancecoaching')]
    public function deleteSeancecoaching(ManagerRegistry $doctrine,SeancecoachingRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $Se=$repo->find($id);
        $manager->remove($Se);
        $manager->flush();
        return $this->redirectToRoute('app_afficherSeancecoachingback');
    }

    #[Route('/updateSeancecoaching/{id}', name: 'app_updateSeancecoaching')]
    public function updateSeancecoaching($id,Seancecoaching $Seancecoaching,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateSeancecoachingType::class, $Seancecoaching);
        $form->handleRequest($request);
        $img=$Seancecoaching->getImageSeance();

        
        $entityManager->getRepository(Seancecoaching::class)->find($id);
        $Seancecoaching->setImageSeance($img);


        if ($form->isSubmitted() && $form->isValid()) {
            
            $file = $request->files->get('update_seancecoaching')['imageSeance'];
            if ($file)
            {

            
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('imagesnada_directory'), $filename);
            $Seancecoaching->setImageSeance($filename);
            
            $entityManager->persist($Seancecoaching);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherSeancecoachingback');
            }
            else 
            {
                $Seancecoaching->setImageSeance($img);
                $entityManager->persist($Seancecoaching);
                $entityManager->flush();
                return $this->redirectToRoute('app_afficherSeancecoachingback'); 
            }
        }

        return $this->render('Seancecoaching/modifierSeancecoaching.html.twig', [
            'formSeancecoaching' => $form->createView(),
        ]);
    }
    //affichage seance back 
    #[Route('/afficherSeancecoachingback', name: 'app_afficherSeancecoachingback')]
    public function afficherSeancecoachingback(SeancecoachingRepository $repo)
    {
        return $this->render('Seancecoaching/afficherSeancecoachingback.html.twig', [
            'Seancecoaching' => $repo->findAll(),
        ]);
    }
    //details:
     #[Route('/detailSeancecoachingfront/{id}', name: 'app_detailSeancecoachingfront')]
     public function detailSeancecoachingfront(SeancecoachingRepository $repo,$id)
     {
         return $this->render('Seancecoaching/detailSeancecoachingfront.html.twig', [
             'Seancecoaching' => $repo->find($id),
        ]);
     }
     //recherche :
     #[Route('/rechercheSeancecoaching', name: 'rechercheSeancecoaching')]
         public function rechercheSeancecoaching(Request $request)
    {
        $Seancecoaching=$request->get('evenm');

        $Seancecoaching=$this->getDoctrine()->getManager()->createQuery("select e from Seancecoaching e where e.titreSeance like '%".$Seancecoaching."%'")
        ->getResult();

        $jsonData=array();
        $idx=0;
        foreach ($Seancecoaching as $liv) {
            $temp=array(
                'id'=>$liv->getId(),
                'dateDebutSeance'=>$liv->getDateDebutSeance(),
                'DateFinSeance'=>$liv->getDateFinSeance(),
                'PrixSeance'=>$liv->getPrixSeance(),
                'DescriptionSeance'=>$liv->getDescriptionSeance(),
                'ImageSeance'=>$liv->getImageSeance(),
                'titreSeance'=>$liv->getTitreSeance(),
            );
            $jsonData[$idx++]=$temp;

        }

        return new JsonResponse($jsonData);

    }
   
    }




