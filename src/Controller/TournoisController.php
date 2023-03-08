<?php

namespace App\Controller;

use TCPDF;
use Twig\Environment;
use App\Entity\Tournois;
use Symfony\Flex\Options;
use App\Entity\HistoryRecord;
use App\Form\TournoisFormType;
use App\Form\UpdateTournoisType;
use App\Repository\TournoisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\HistoryRecordRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;



class TournoisController extends AbstractController
{
    #[Route('/afficherTournois', name: 'app_afficherTournois')]
    public function afficherTournois(TournoisRepository $repo)
    {
        return $this->render('Tournois/afficherTournois.html.twig', [
            'Tournois' => $repo->findAll(),
        ]);
    }
   

    #[Route('/ajouterTournois', name: 'app_ajouterTournois')]
    public function ajouterTournois(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $Tournois=new Tournois();

        $form=$this->createForm(TournoisFormType::class, $Tournois);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($Tournois);
            $manager->flush();
            return $this->redirectToRoute('app_afficherTournois');
           }

        return new Response($twig->render('Tournois/ajouterTournois.html.twig',[
            'formTournois' => $form->createView(),
            'user' => $this->getUser()
        ]));
    }

    #[Route('/deleteTournois/{id}', name: 'app_deleteTournois')]
    public function deleteTournois(ManagerRegistry $doctrine, TournoisRepository $repo, $id): Response
    {
        $manager = $doctrine->getManager();
        $tou = $repo->find($id);

        if (!$tou) {
            throw $this->createNotFoundException('No tournois found for id '.$id);
        }

        $historyRecord = new HistoryRecord();
        $historyRecord->setEntityName(Tournois::class);
        $historyRecord->setDeletedEntityId($tou->getId());
        $historyRecord->setDeletedAt(new \DateTime());

        $manager->remove($tou);
        $manager->persist($historyRecord);
        $manager->flush();

        return $this->redirectToRoute('app_afficherTournois');
    }
    #[Route('/history', name: 'app_history')]
    public function history(HistoryRecordRepository $historyRecordRepository, EntityManagerInterface $entity_manager): Response
    {
        $historyRecords = $historyRecordRepository->findAll();

        return $this->render('history/index.html.twig', [
            'historyRecords' => $historyRecords,
            'entity_manager' => $entity_manager,
        ]);
    }
    #[Route('/updateTournois/{id}', name: 'app_updateTournois')]
    public function updateTournois($id,Tournois $Tournois,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateTournoisType::class, $Tournois);
        $form->handleRequest($request);
        
        $entityManager->getRepository(Tournois::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($Tournois);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherTournois');
        }

        return $this->render('Tournois/modifierTournois.html.twig', [
            'formTournois' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
   
   
     ///front///
     #[Route('/afficherTournoisFront', name: 'app_afficherTournoisFront')]
     public function afficherTournoisFront(TournoisRepository $repo)
     {
         return $this->render('Tournois/afficherTournoisFront.html.twig', [
             'Tournois' => $repo->findAll(),
             'user' => $this->getUser()
         ]);
     }

     #[Route('/generate_pdf', name: 'app_generate_pdf')]
    public function generatePdfAction()
    {
        // Get the list of tournois from the database
        $tournois = $this->getDoctrine()->getRepository(Tournois::class)->findAll();

// Set up the PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('Your Name');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('List of Tournois');
        $pdf->SetSubject('List of Tournois');

// Add a page to the PDF document
        $pdf->AddPage();

// Add the tournois to the PDF document
        $html = '<h1>List of Tournois</h1><table><tr><th>ID</th><th>NBRparticipants</th><th>DureeTournois</th><th>DateDebutTournois</th><th>nomJeux</th></tr>';
        foreach ($tournois as $tournoi) {
            $html .= '<tr><td>' . $tournoi->getId() . '</td><td>' . $tournoi->getNBRparticipants() . '</td><td>' . $tournoi->getDureeTournois() . '</td><td>' . $tournoi->getDateDebutTournois()->format('Y-m-d') . '</td><td>' . $tournoi->getIdjeuxfk()->getNom() . '</td></tr>';
        }
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF document as a response
        $response = new Response($pdf->Output('list_of_tournois.pdf', 'D'));
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
