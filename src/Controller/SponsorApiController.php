<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Evenement;
use App\Entity\Sponsor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SponsorApiController extends AbstractController
{ 
  
    #[Route('/afficherSponsor/api', name: 'app_afficher_Sponsor_api')]
    public function afficherSponsor(ManagerRegistry $doctrine,NormalizerInterface $normalizer)
    {
        $rep=$doctrine->getRepository(persistentObject:Sponsor::class);
        $list=$rep->findAll();
        $jsonContent=$normalizer->normalize($list,'json',['groups'=>'list']);
        return new Response(json_encode($jsonContent));
       
    }
   
    #[Route('/ajouterSponsor/api', name: 'app_ajouter_Event_api')]
        public function AddFormSponsorMaker(Request $request, ManagerRegistry $doctrine, NormalizerInterface $normalizer)
        {
            
            $em=$doctrine->getManager();
            $list=new Sponsor();
          
            $list->setNomSponsor($request->get('NomSponsor'));
            $list->setNumTelSponsor($request->get('NumTelSponsor'));
            $list->setEmailSponsor( $request->get('EmailSponsor'));
            $list->setDomaineSponsor( $request->get('DomaineSponsor'));
            $list->setAdresseSponsor($request->get('AdresseSponsor'));
            $list->setLogoSponsor($request->get('LogoSponsor'));
            $list->setMontantSponsoring($request->get('MontantSponsoring'));
          
                $em->persist($list);
                $em->flush();
                $jsonContent=$normalizer->normalize($list,'json',['groups'=>'list']);
               return new Response(json_encode($jsonContent));
           
        }

        #[Route('/supprimerSponsor/api/{id}', name: 'app_supprimer_Sponsor_api')]
        public function supprimerSponsorID (ManagerRegistry $doctrine, Sponsor $list, NormalizerInterface $Normalizer)
        {   
            
            $em=$doctrine->getManager();
            $em->remove($list);
            $em->flush();
            $jsonContent=$Normalizer->normalize($list,'json',['groups'=>'list']);
    
            return new Response("Sponsor deleted".json_encode($jsonContent));
           
           
        }
     
       

        #[Route('/modifierSponsor/api/{id}', name: 'app_modifier_Sponsor_api')]
        public function updateFormSponsorMaker(Request $request, NormalizerInterface $Normalizer, $id)
        { 
                $em = $this->getDoctrine()->getManager();
                $list = $em->getRepository(Sponsor::class)->find($id);
                $list->setNomSponsor($request->get('NomSponsor'));
                $list->setNumTelSponsor($request->get('NumTelSponsor'));
                $list->setEmailSponsor( $request->get('EmailSponsor'));
                $list->setDomaineSponsor( $request->get('DomaineSponsor'));
                $list->setAdresseSponsor($request->get('AdresseSponsor'));
                $list->setLogoSponsor($request->get('LogoSponsor'));
                $list->setMontantSponsoring($request->get('MontantSponsoring'));
                $em->persist($list);
                $em->flush();
    
                $jsonContent=$Normalizer->normalize($list,'json',['groups'=>'list']);
                return new Response(json_encode($jsonContent));
           
        }

    
          
        
}
