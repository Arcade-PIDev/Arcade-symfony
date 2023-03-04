<?php

namespace App\Controller;


use App\Form\ParticipationSearchType;
use App\Repository\ParticipationsRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ParticipationsFormType;
use App\Form\UpdateParticipationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Participations;
use Doctrine\Persistence\ManagerRegistry;

class ParticipationsController extends AbstractController
{
    #[Route('/afficherParticipations', name: 'app_afficherParticipations')]
    public function afficherParticipations(ParticipationsRepository $repo)
    {
        return $this->render('Participations/afficherParticipations.html.twig', [
            'Participations' => $repo->findAll(),
        ]);
    }

    #[Route('/ajouterParticipations', name: 'app_ajouterParticipations')]
    public function ajouterParticipations(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $Participations=new Participations();

        $form=$this->createForm(ParticipationsFormType::class, $Participations);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           

            $manager->persist($Participations);
            $manager->flush();
            $this->addFlash('success', 'Your added with succes');
            return $this->redirectToRoute('app_afficherParticipations');

           }

        return new Response($twig->render('Participations/ajouterParticipations.html.twig',[
            'formParticipations' => $form->createView()
        ]));

    }

    #[Route('/deleteParticipations/{id}', name: 'app_deleteParticipations')]
    public function deleteParticipations(ManagerRegistry $doctrine,ParticipationsRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $Par=$repo->find($id);
        $manager->remove($Par);
        $manager->flush();
        return $this->redirectToRoute('app_afficherParticipations');
    }

    #[Route('/updateParticipations/{id}', name: 'app_updateParticipations')]
    public function updateParticipations($id,Participations $Participations,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateParticipationsType::class, $Participations);
        $form->handleRequest($request);
        
        $entityManager->getRepository(Participations::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($Participations);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherParticipations');
        }

        return $this->render('Participations/modifierParticipations.html.twig', [
            'formParticipations' => $form->createView(),
        ]);
    }



    #[Route('/participations/search', name: 'participations_search')]
    public function search(Request $request, ParticipationsRepository $repository): Response
    {
        $form = $this->createForm(ParticipationSearchType::class);
        $form->handleRequest($request);

        $result = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $result = $repository->searchByNomJoueur($data['query']);
        }

        return $this->render('participations/search.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }
    public function searchaa(Request $request)
    {
        $form = $this->createForm(ParticipationSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nomJoueur = $form->get('nomJoueur')->getData();
            $participations = $this->getDoctrine()->getRepository(Participations::class)->findBy(['nom_joueur' => $nomJoueur]);

            $data = [];
            foreach ($participations as $participation) {
                $data[] = [
                    'nomJoueur' => $participation->getNomJoueur(),
                    'nombreParticipants' => $participation->getNombreParticipants(),
                    'niveau' => $participation->getNiveau(),
                    'dateParticipations' => $participation->getDateParticipations()->format('Y-m-d'),
                    'titreSeance' => $participation->getTitreSeance(),
                ];
            }

            if (empty($data)) {
                return new JsonResponse(['message' => 'No results found'], Response::HTTP_NOT_FOUND);
            } else {
                return new JsonResponse($data);
            }
        }

        return $this->render('participations/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/data", name="export_data")
     */
    public function exportData()
    {
        // Fetch data from the database
        $entityManager = $this->getDoctrine()->getManager();
        $participations = $entityManager->getRepository(Participations::class)->findAll();

        // Create a new Excel object
        $spreadsheet = new Spreadsheet();

        // Set the active sheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Add the headers to the worksheet
        $worksheet->setCellValue('A1', 'ID');
        $worksheet->setCellValue('B1', 'Nom du joueur');
        $worksheet->setCellValue('C1', 'Nombre de participants');
        $worksheet->setCellValue('D1', 'Niveau');
        $worksheet->setCellValue('E1', 'Date de participation');
        $worksheet->setCellValue('F1', 'ID de la séance de coaching');

        // Add the data rows to the worksheet
        $rowNumber = 2;
        foreach ($participations as $participation) {
            $worksheet->setCellValue('A' . $rowNumber, $participation->getId());
            $worksheet->setCellValue('B' . $rowNumber, $participation->getNomJoueur());
            $worksheet->setCellValue('C' . $rowNumber, $participation->getNombreParticipants());
            $worksheet->setCellValue('D' . $rowNumber, $participation->getNiveau());
            $worksheet->setCellValue('E' . $rowNumber, $participation->getDateParticipations()->format('Y-m-d'));
            $worksheet->setCellValue('F' . $rowNumber, $participation->getIdseancefk()->getId());
            $rowNumber++;
        }

        // Create the Excel file and write it to the response
        $writer = new Xlsx($spreadsheet);
        $fileName = 'participations.xlsx';
        $tempFilePath = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFilePath);

        // Send the file in the response
        $response = new BinaryFileResponse($tempFilePath);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName);
        return $response;
    }

}

